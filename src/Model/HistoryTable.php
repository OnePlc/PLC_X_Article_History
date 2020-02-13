<?php
/**
 * HistoryTable.php - History Table
 *
 * Table Model for History History
 *
 * @category Model
 * @package Article\History
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Article\History\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;
use OnePlace\Article\History\Model\History;

class HistoryTable extends CoreEntityTable {

    /**
     * HistoryTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'articlehistory-single';
    }

    /**
     * Get History Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'History_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save History Entity
     *
     * @param History $oHistory
     * @return int History ID
     * @since 1.0.0
     */
    public function saveSingle(History $oHistory) {
        $aDefaultData = [
            'label' => $oHistory->label,
        ];

        return $this->saveSingleEntity($oHistory,'History_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return History
     * @since 1.0.0
     */
    public function generateNew() {
        return new History($this->oTableGateway->getAdapter());
    }
}