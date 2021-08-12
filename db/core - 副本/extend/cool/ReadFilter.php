<?php

namespace cool;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_Reader_IReadFilter;
class ReadFilter implements PHPExcel_Reader_IReadFilter  
    {  
        private $_startRow = 0;     // 开始行  
        private $_endRow = 0;       // 结束行  
        private $_columns = array();    // 列跨度  
        public function __construct($startRow, $endRow, $columns) {  
            $this->_startRow = $startRow;  
            $this->_endRow       = $endRow;  
            $this->_columns      = $columns;  
        }  
        public function readCell($column, $row, $worksheetName = '') {  
            if ($row >= $this->_startRow && $row <= $this->_endRow) {  
                if (in_array($column,$this->_columns)) {  
                    return true;  
                }  
            }  
            return false;  
        }  
    }  