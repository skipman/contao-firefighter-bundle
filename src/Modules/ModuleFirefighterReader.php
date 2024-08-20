<?php declare(strict_types=1);

namespace Skipman\ContaoFirefighterBundle\Modules;

use Contao\BackendTemplate;
use Contao\Config;
use Contao\CoreBundle\Exception\InternalServerErrorException;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\Environment;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Contao\Database;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Skipman\ContaoFirefighterBundle\Models\FirefighterModel;
use Skipman\ContaoFirefighterBundle\Classes\Firefighter;

class ModuleFirefighterReader extends ModuleFirefighter
{
    protected $strTemplate = 'mod_firefighterreader';

    public function generate()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.mb_strtoupper($GLOBALS['TL_LANG']['FMD']['firefighterreader'][0]).' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = StringUtil::specialcharsUrl(System::getContainer()->get('router')->generate('contao_backend', ['do' => 'themes', 'table' => 'tl_module', 'act' => 'edit', 'id' => $this->id]));

            return $objTemplate->parse();
        }

        // Do not index or cache the page if no firefighter item has been specified
        if (!Input::get('auto_item')) {
            global $objPage;
            $objPage->noSearch = 1;
            $objPage->cache = 0;

            return '';
        }

        $this->firefighter_archives = $this->sortOutProtected(StringUtil::deserialize($this->firefighter_archives));

        if (empty($this->firefighter_archives) || !\is_array($this->firefighter_archives)) {
            throw new InternalServerErrorException('The news reader ID '.$this->id.' has no archives specified.', $this->id);
        }

        return parent::generate();
    }

    protected function compile(): void
    {
        if ($this->overviewPage) {
            $this->Template->referer = PageModel::findById($this->overviewPage)->getFrontendUrl();
            $this->Template->back = $this->customLabel ?: $GLOBALS['TL_LANG']['MSC']['goBack'];
        } else {
            $this->Template->referer = 'javascript:history.go(-1)';
            $this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
        }

        $objItem = FirefighterModel::findPublishedByParentAndIdOrAlias(Input::get('auto_item'), $this->firefighter_archives);

        if (null === $objItem) {
            throw new PageNotFoundException('Page not found: '.Environment::get('uri'));
        }

        $this->Template->items = $this->parseItem($objItem);
    }

    /**
     * Parse a single item and return it as string.
     *
     * @param FirefighterModel $objItem
     * @param bool $blnAddArchive
     * @param string $strClass
     * @param int $intCount
     *
     * @return string
     */
    protected function parseItem($objItem, $blnAddArchive = false, $strClass = '', $intCount = 0): string
    {
        global $objPage;
        $objTemplate = new FrontendTemplate($this->firefighter_template);
        $objTemplate->setData($objItem->row());

        // Get the local functions
        $localFunctions = StringUtil::deserialize($objItem->membersFunctionLocalWizard);
        if (is_array($localFunctions) && !empty($localFunctions)) {
            foreach ($localFunctions as &$function) {
                $function['long'] = $this->getFunctionLongName($function['membersFunctionLocal']);
                $function['period'] = $function['membersFunctionLocalPeriod'] ?? '';
            }
            $objTemplate->membersFunctionLocal = $localFunctions;
        }

        // Get the section functions
        $sectionFunctions = StringUtil::deserialize($objItem->membersFunctionSectionWizard);
        if (is_array($sectionFunctions) && !empty($sectionFunctions)) {
            foreach ($sectionFunctions as &$function) {
                $function['long'] = $this->getFunctionLongName($function['membersFunctionSection']);
                $function['period'] = $function['membersFunctionSectionPeriod'] ?? '';
            }
            $objTemplate->membersFunctionSection = $sectionFunctions;
        }

        // Add other item data to the template
        $objTemplate->class = ('' !== $objItem->cssClass ? ' '.$objItem->cssClass : '').$strClass;
        $objTemplate->headline = $objItem->headline;
        $objTemplate->linkHeadline = $this->generateLink($objItem->headline, $objItem, $blnAddArchive);
        $objTemplate->more = $this->generateLink($GLOBALS['TL_LANG']['MSC']['more'], $objItem, $blnAddArchive, true);
        $objTemplate->link = Firefighter::generateFirefighterUrl($objItem, $blnAddArchive);
        $objTemplate->count = $intCount;
        $objTemplate->text = '';
        $objTemplate->hasText = false;
        $objTemplate->hasTeaser = false;
        $objTemplate->membersFirstname = $objItem->membersFirstname;
        $objTemplate->membersLastname = $objItem->membersLastname;
        $objTemplate->membersRank = $objItem->membersRank;
        $objTemplate->membersRankShortAbbr = '';
        $objTemplate->membersRankLongAbbr = '';
        $objTemplate->rankImage = '';

        // Fetch homebase details
        $homebaseDetails = $this->getHomebaseDetails($objItem->membersHomebase);
        $objTemplate->membersHomebase = $homebaseDetails['name'];
        $objTemplate->membersHomebaseWebsite = $homebaseDetails['website'];
        $objTemplate->membersEmail = $objItem->membersEmail;
        $objTemplate->membersPhone = $objItem->membersPhone;
        $objTemplate->membersPhoneFormatted = $this->formatPhoneNumber($objItem->membersPhone);

        // Add the rank image
        if ($objItem->membersRank) {
            $rankInfo = $this->getMembersRank($objItem->membersRank, $objItem->membersRankHonory);
            $objTemplate->membersRankShortAbbr = $rankInfo['short'];
            $objTemplate->membersRankLongAbbr = $rankInfo['long'];
            $objTemplate->rankImage = $rankInfo['image'];
        }

        // Add the member image
        if ($objItem->addImage && '' !== $objItem->singleSRC) {
            $objTemplate->memberImage = $this->getMemberImage($objItem);
        }

        return $objTemplate->parse();
    }

    private function getMemberImage($objItem)
    {
        if ($objItem->singleSRC) {
            $objModel = FilesModel::findByUuid($objItem->singleSRC);

            if ($objModel !== null && is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $objModel->path)) {
                return [
                    'path' => $objModel->path,
                    'alt' => $objItem->alt,
                    'title' => $objItem->imageTitle
                ];
            }
        }

        return null;
    }

    private function getMembersRank($membersRank, $membersRankHonory)
    {
        $result = Database::getInstance()->prepare("SELECT rank_short, rank_long, singleSRC FROM tl_firefighter_ranks WHERE id=?")
                                        ->execute($membersRank);

        if ($result->numRows > 0) {
            $rankShort = $result->rank_short;
            $rankLong = $result->rank_long;

            if ($membersRankHonory) {
                return [
                    'short' => "E" . $rankShort,
                    'long' => "Ehren" . strtolower($rankLong),
                    'image' => $this->getRankImage($result->singleSRC)
                ];
            } else {
                return [
                    'short' => $rankShort,
                    'long' => $rankLong,
                    'image' => $this->getRankImage($result->singleSRC)
                ];
            }
        }

        return null;
    }

    private function getRankImage($singleSRC)
    {
        if ($singleSRC) {
            $objRankImage = FilesModel::findByUuid($singleSRC);

            if ($objRankImage !== null && is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $objRankImage->path)) {
                return $objRankImage->path;
            }
        }

        return null;
    }

    private function getHomebaseDetails($homebaseId): array
    {
        $result = Database::getInstance()
            ->prepare("SELECT ffname, socialChannels FROM tl_firefighter_departments WHERE id=?")
            ->execute($homebaseId);

        if ($result->numRows > 0) {
            $socialChannels = StringUtil::deserialize($result->socialChannels, true);
            $website = '';
            $facebook = '';

            foreach ($socialChannels as $channel) {
                if ($channel['platform'] === 'Webseite' && !empty($channel['url'])) {
                    $website = $channel['url'];
                } elseif ($channel['platform'] === 'Facebook' && !empty($channel['url'])) {
                    $facebook = $channel['url'];
                }
            }

            return [
                'name' => $result->ffname,
                'website' => $website ?: $facebook,
            ];
        }

        return [
            'name' => '',
            'website' => '',
        ];
    }

    protected function getFunctionLongName($functionId): string
    {
        $function = Database::getInstance()
            //->prepare("SELECT function_short FROM tl_firefighter_functions WHERE id=?")
            ->prepare("SELECT function_long FROM tl_firefighter_functions WHERE id=?")
            ->execute($functionId);

        return $function->numRows ? $function->function_long : '';
    }

    /**
     * Format phone number to remove all non-digit characters and add the international dialing code.
     *
     * @param string $phoneNumber
     *
     * @return string
     */
    protected function formatPhoneNumber($phoneNumber): string
    {
        // Remove all non-digit characters
        $formattedPhone = preg_replace('/\D/', '', $phoneNumber);
        // Remove leading zero and add international dialing code
        return 'tel:+43' . ltrim($formattedPhone, '0');
    }
}