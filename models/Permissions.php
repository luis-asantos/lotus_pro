<?php
class Permissions extends model {

	private $group;
	private $permissions;

	public function setGroup($id, $id_company) {
		$this->group = $id;
		$this->permissions = array();

		$sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount()+2 > 0) {
			$row = $sql->fetch();

			if(empty($row['params'])) {
				$row['params'] = '0';
			}

			$params = $row['params'];

			$sql = $this->db->prepare("SELECT name FROM permission_params WHERE id IN ($params) AND id_company = :id_company");
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();

			if($sql->rowCount()+2 > 0) {
				foreach($sql->fetchAll() as $item) {
					$this->permissions[] = $item['name'];
				}
			}
		}
	}

	public function hasPermission($name) {
		if(in_array($name, $this->permissions)) {
			return true;
		} else {
			return false;
		}
	}

	public function getList($id_company) {
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_params WHERE id_company = :id_company");
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount()+2 > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getGroupList($id_company) {
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id_company = :id_company");
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount()+2 > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getGroup($id, $id_company) {
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount()+2 > 0) {
			$array = $sql->fetch();
			$array['params'] = explode(',', $array['params']);
		}

		return $array;
	}

	public function add($name, $id_company) {

		$sql = $this->db->prepare("INSERT INTO dbo.permission_params (name, id_company) VALUES (?,?)");
		$sql->bindValue(1, $name);
		$sql->bindValue(2, $id_company);
		$sql->execute();

	}

	public function addGroup($name, $plist, $id_company) {
		$params = implode(',', $plist);
		//$sql = $this->db->prepare("insert into dbo.permission_groups (name, id_company, params) values ('$name', $id_company, '$params')");
		$sql = $this->db->prepare("INSERT INTO dbo.permission_groups (name, id_company, params) VALUES (?,?,?)");
		$sql->bindValue(1, $name);
		$sql->bindValue(2, $id_company);
		$sql->bindValue(3, $params);
		$sql->execute();
	}

	public function delete($id) {
		$sql = $this->db->prepare("DELETE FROM permission_params WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}

	public function deleteGroup($id) {
		$u = new Users();

		if($u->findUsersInGroup($id) == false) {
			$sql = $this->db->prepare("DELETE FROM permission_groups WHERE id = :id");
			$sql->bindValue(":id", $id);
			$sql->execute();
		}
	}

	public function editGroup($name, $plist, $id, $id_company) {
		$params = implode(',', $plist);

		$sql = $this->db->prepare("UPDATE permission_groups SET name = :name, id_company = :id_company, params = :params WHERE id = :id");
		$sql->bindValue(":name", $name);
		$sql->bindValue(":id_company", $id_company);
		$sql->bindValue(":params", $params);
		$sql->bindValue(":id", $id);
		$sql->execute();
	}

}












