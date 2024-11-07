<?php
class db
{

	public $connection;
	protected $query;
	protected $show_errors = TRUE;
	protected $query_closed = TRUE;
	public $query_count = 0;

	public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = '', $charset = 'latin1')
	{
		$this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($this->connection->connect_error) {
			$this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
		}
		$this->connection->set_charset($charset);
	}

	public function query($query)
	{
		if (!$this->query_closed) {
			$this->query->close();
		}
		if ($this->query = $this->connection->prepare($query)) {
			if (func_num_args() > 1) {
				$x = func_get_args();
				$args = array_slice($x, 1);
				$types = '';
				$args_ref = array();
				foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
							$types .= $t = $this->_gettype($args[$k][$j]);

							//tratamento contra script injection
							if ($t == 's') {
								$padrao = '/<script\b[^>]*>(.*?)<\/script>/is';

								$a = preg_replace($padrao, '', $a);

								$a = str_replace('<script', '', $a);
								$a = str_replace('</script', '', $a);
							}

							$args_ref[] = &$a;
						}
					} else {
						$types .= $this->_gettype($args[$k]);
						$args_ref[] = &$arg;
					}
				}
				array_unshift($args_ref, $types);
				call_user_func_array(array($this->query, 'bind_param'), $args_ref);
			}
			$this->query->execute();
			if ($this->query->errno) {
				$this->error('Unable to process MySQL query (check your params) - (query) ' . $query . ' - ' . $this->query->error);
			}
			$this->query_closed = FALSE;
			$this->query_count++;
		} else {
			$this->error('Unable to prepare MySQL statement (check your syntax) - (query) ' . $query . ' - ' . $this->connection->error);
		}
		return $this;
	}


	public function fetchAll($callback = null)
	{
		$params = array();
		$row = array();
		$meta = $this->query->result_metadata();
		while ($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
		}
		call_user_func_array(array($this->query, 'bind_result'), $params);
		$result = array();
		while ($this->query->fetch()) {
			$r = array();
			foreach ($row as $key => $val) {
				$r[$key] = $val;
			}
			if ($callback != null && is_callable($callback)) {
				$value = call_user_func($callback, $r);
				if ($value == 'break') break;
			} else {
				$result[] = $r;
			}
		}
		$this->query->close();
		$this->query_closed = TRUE;
		return $result;
	}

	public function fetchArray()
	{
		$params = array();
		$row = array();
		$meta = $this->query->result_metadata();
		while ($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
		}
		call_user_func_array(array($this->query, 'bind_result'), $params);
		$result = array();
		while ($this->query->fetch()) {
			foreach ($row as $key => $val) {
				$result[$key] = $val;
			}
		}
		$this->query->close();
		$this->query_closed = TRUE;
		return $result;
	}

	public function close()
	{
		return $this->connection->close();
	}

	public function numRows()
	{
		$this->query->store_result();
		return $this->query->num_rows;
	}

	public function affectedRows()
	{
		return $this->query->affected_rows;
	}

	public function lastInsertID()
	{
		return $this->connection->insert_id;
	}

	public function error($error)
	{
		if ($this->show_errors) {
			exit($error);
		}
	}

	public function Begin()
	{
		$this->connection->begin_transaction();
	}

	public function Commit()
	{
		$this->connection->commit();
	}

	public function Rollback()
	{
		$this->connection->rollback();
	}

	public function Error_db()
	{
		return $this->connection->error;
	}

	public function NextID($table)
	{
		$this->Begin();

		// Inserir uma nova linha na tabela de sequência
		$this->query("INSERT INTO _sequence_{$table} (sequence) VALUES (NULL)");

		// Obter o ID inserido
		$NextID = $this->lastInsertID();

		// Excluir linhas antigas da tabela de sequência
		$this->query("DELETE FROM _sequence_{$table} WHERE sequence < ?", array($NextID));

		$this->Commit();

		return $NextID;
	}

	public function NextIDCompound($table, $id)
	{
		$SQL_MAX = 'SELECT (MAX(sequence) + 1) AS max FROM _sequenceCompound_' . $table . ' WHERE id = ?';
		$max = $this->query($SQL_MAX, array($id))->fetchArray()['max'];
		$SQL_SEQ = 'INSERT INTO _sequenceCompound_' . $table . ' (id, sequence) VALUES (?, ?)';
		$this->query($SQL_SEQ, array($id,$max));
		$SQL_SEQ_DEL = 'DELETE FROM _sequenceCompound_' . $table . ' WHERE id = ? AND sequence < ?';
		$this->query($SQL_SEQ_DEL, array($id, $max));

		return $max;
	}

	public function fieldCount()
	{
		return $this->connection->field_count;
		//Exemplo de uso: $QtdDeColunasDaQuery = $db_datahealth->query($sql)->fieldCount();
	}

	private function _gettype($var)
	{
		if (is_string($var)) return 's';
		if (is_float($var)) return 'd';
		if (is_int($var)) return 'i';
		return 'b';
	}
}