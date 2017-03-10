<?php
/**
 * filter.php
 * 
 */
namespace Skinny\DataBase;

class Filter
{

    public function filterParser($filter=array(), &$object)
    {
        if (!is_array($filter)) return $filter;

        $tPre = ('`'.$object->getTableName().'`').'.';

        $where = [1];
        

        $qb = $object->database()->createQueryBuilder();

        $cols = $object->_columns();

        // 过滤无用的filter条件
        $filter = array_where($filter, function($filterKey, $filterValue) use ($cols) {
            return !is_null($filterValue) &&
                   (isset($cols[$filterKey]) || strpos($filterKey, '|'));
        });

        foreach($filter as $filterKey => $filterValue)
        {
            if (strpos($filterKey, '|'))
            {
                list($columnName, $type) = explode('|', $filterKey);
                $where[] = $this->processTypeSql($tPre.$columnName, $type, $filterValue, $qb);
            }
            else
            {
                $columnName = $filterKey;
                if (is_array($filterValue))
                {

                    $where[] = $this->processTypeSql($tPre.$columnName, 'in', $filterValue, $qb);
                }
                else
                {
                    $where[] = $this->processTypeSql($tPre.$columnName, 'nequal', $filterValue, $qb);
                }
            }
        }
        
        return call_user_func_array(array($qb->expr(), 'andX'), $where);
    }

    private function processTypeSql($columnName, $type, $filterValue, &$qb)
    {
        $db = $qb->getConnection();
        switch ($type)
        {
            case 'than': 
                // 大于 >
                $sql = $qb->expr()->gt($columnName, $db->quote($filterValue, \PDO::PARAM_INT));
                break;
            case 'lthan':
                // 小于 < 
                $sql = $qb->expr()->lt($columnName, $db->quote($filterValue, \PDO::PARAM_INT));
                break;
            case 'nequal':
            case 'tequal':
                // 等于 =
                $sql = $qb->expr()->eq($columnName, $db->quote($filterValue));
                break;
            case 'noequal':
                // 不等于 <>
                $sql = $qb->expr()->neq($columnName, $db->quote($filterValue));
                break;

            case 'sthan':
                // 小于等于 <=
                $sql = $qb->expr()->lte($columnName, $db->quote($filterValue, \PDO::PARAM_INT));
                break;
            case 'bthan':
                // 大于等于 >=
                $sql = $qb->expr()->gte($columnName, $db->quote($filterValue, \PDO::PARAM_INT));
                break;
            case 'has':
                $sql = $qb->expr()->like($columnName, $db->quote('%'.$filterValue.'%', \PDO::PARAM_STR));
                break;
            case 'head':
                $sql = $qb->expr()->like($columnName, $db->quote($filterValue.'%', \PDO::PARAM_STR));
                break;
            case 'foot':
                $sql = $qb->expr()->like($columnName, $db->quote('%'.$filterValue, \PDO::PARAM_STR));
                break;
            case 'nohas':
                $sql = $qb->expr()->notlike($columnName, $db->quote('%'.$filterValue.'%', \PDO::PARAM_STR));
                break;
            case 'between':
                $sql = $qb->expr()->andX($qb->expr()->gte($columnName, $db->quote($filterValue[0], \PDO::PARAM_INT)),
                                         $qb->expr()->lt($columnName, $db->quote($filterValue[1], \PDO::PARAM_INT)));
                break;
            case 'in':
                $filterValue = (array)$filterValue;
                if (empty($filterValue)) throw new InvalidArgumentException("filter column:{$columnName} in type, cannot empty");
                array_walk($filterValue, function(&$value) use ($qb) {
                    $value = $qb->getConnection()->quote($value);
                });
                $sql = $qb->expr()->in($columnName, $filterValue);
                break;
            case 'notin':
                $filterValue = (array)$filterValue;
                array_walk($filterValue, function(&$value) use ($qb) {
                    $value = $qb->getConnection()->quote($value);
                });
                $sql = $qb->expr()->notin($columnName, $filterValue);
                break;
            default:
                throw new \ErrorException(sprintf('column : %s dbeav filter donnot support type:%s', $columnName, $type));
        }
        return $sql;
    }
}

