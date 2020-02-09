<?php
/**
 * HistoryController.php - Main Controller
 *
 * Main Controller for Article History Plugin
 *
 * @category Controller
 * @package Article\History
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Article\History\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Article\History\Model\HistoryTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use OnePlace\Article\Model\ArticleTable;

class HistoryController extends CoreEntityController {
    /**
     * Article Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * ArticleController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ArticleTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,HistoryTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'articlehistory-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function attachHistoryForm($oItem = false) {
        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'articlehistory-single']);

        $aFields = [];
        $aUserFields = CoreEntityController::$oSession->oUser->getMyFormFields();
        if(array_key_exists('articlehistory-single',$aUserFields)) {
            $aFieldsTmp = $aUserFields['articlehistory-single'];
            if(count($aFieldsTmp) > 0) {
                # add all contact-base fields
                foreach($aFieldsTmp as $oField) {
                    if($oField->tab == 'history-base') {
                        $aFields[] = $oField;
                    }
                }
            }
        }

        $aFieldsByTab = ['history-base'=>$aFields];
        # Try to get adress table
        try {
            $oHistoryTbl = CoreEntityController::$oServiceManager->get(HistoryTable::class);
        } catch(\RuntimeException $e) {
            echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }

        if(!isset($oHistoryTbl)) {
            return [];
        }

        $aHistories = [];
        $oPrimaryHistory = false;
        if($oItem) {
            # load article addresses
            $oHistories = $oHistoryTbl->fetchAll(false, ['article_idfs' => $oItem->getID()]);
            # get primary address
            if (count($oHistories) > 0) {
                foreach ($oHistories as $oAddr) {
                    $aHistories[] = $oAddr;
                }
            }
        }

        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'article_history'=> [
                    'oHistories'=>$aHistories,
                    'oForm'=>$oForm,
                    'aFormFields'=>$aFieldsByTab,
                ]
            ]
        ];
    }

    private function updateArticlePrice($fNewPrice,$iArticleID) {
        try {
            $oArtTbl = CoreEntityController::$oServiceManager->get(ArticleTable::class);
        } catch(\RuntimeException $e) {
            return false;
        }

        if(isset($oArtTbl)) {
            # Save price on article
            $oArtTbl->updateAttribute('price_sell',$fNewPrice,'Article_ID',$iArticleID);
        }
    }

    public function attachHistoryToArticle($oItem,$aRawData) {
        $oItem->article_idfs = $aRawData['ref_idfs'];

        # Save new price to article
        $this->updateArticlePrice($oItem->price,$oItem->article_idfs);

        return $oItem;
    }

    public function addAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * article-add-before (before show add form)
         * article-add-before-save (before save)
         * article-add-after-save (after save)
         */
        $iArticleID = $this->params()->fromRoute('id', 0);

        return $this->generateAddView('articlehistory','articlehistory-single','article','view',$iArticleID,['iArticleID'=>$iArticleID]);
    }
}
