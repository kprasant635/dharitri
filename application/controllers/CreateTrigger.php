<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CreateTrigger extends CI_Controller {
	
	public function index() {
		$this->createTableUpdates();
		$this->createTableDeletes();
		$this->index1();
		$this->indexUpdates();
	}

    public function index1() {
        $query = "select * from    information_schema.tables where table_type='BASE TABLE' and table_schema='public'";

        $tables = $this->db->query($query)->result();

        foreach ($tables as $table) {
			if(($table->table_name=='generalcode') || ($table->table_name=='ci_sessions')){
				continue;
			}
            /* $template = "CREATE OR REPLACE FUNCTION %name%_delete() RETURNS trigger AS \$BODY\$ "
              . " BEGIN"
              . " INSERT INTO "
              . " %table%(%columns%) VALUES(%columns%); "
              . "RETURN NEW; END;"
              . "\$BODY\$ "
              . " LANGUAGE plpgsql VOLATILE
              COST 100;";

              $trigger = "CREATE TRIGGER %name%_delete
              BEFORE DELETE
              ON %table%
              FOR EACH ROW
              EXECUTE PROCEDURE %name%_delete();";

              $step0 = str_replace('%name%', $table->table_name, $template);
              $step1 = str_replace('%table%', $table->table_name, $step0);

              $query = "SELECT  * FROM information_schema.columns WHERE table_schema = 'public' AND table_name='$table->table_name'";
              $coulms = $this->db->query($query)->result();
              $cols = "";
              foreach ($coulms as $col) {
              $cols .= $col->column_name . ",";
              }
              $cols = rtrim($cols, ",");
              $step2 = str_replace("%columns%", $cols, $step1);
              //$this->db->query($step2);
              echo $step2;
              echo "<br>";
              $trigger1 = str_replace('%name%', $table->table_name, $trigger);
              $trigger2 = str_replace('%table%', $table->table_name, $trigger1);
              $trigger3 = str_replace('%name%', $table->table_name, $trigger2)."\n";
              echo $trigger3;
              echo "<br>";
              echo "----------------------------------------------------<br>";
             */
            $template = "CREATE OR REPLACE FUNCTION %name%_delete() RETURNS trigger AS \$BODY\$ "
                    . " BEGIN"
                    . " INSERT INTO "
                    . " deletes.%table%_updates(%columns%,update_date_time_timestamp) VALUES(%columns_values%,current_timestamp); "
                    . "RETURN NEW; END;"
                    . "\$BODY\$ "
                    . " LANGUAGE plpgsql VOLATILE
                        COST 100;";

            $trigger = "CREATE TRIGGER %name%_delete
                        AFTER DELETE
                        ON %table%
                        FOR EACH ROW
                        EXECUTE PROCEDURE %name%_delete();";

            $step0 = str_replace('%name%', $table->table_name, $template);
            $step1 = str_replace('%table%', $table->table_name, $step0);

            $query = "SELECT  * FROM information_schema.columns WHERE table_schema = 'public' AND table_name='$table->table_name'";
            $coulms = $this->db->query($query)->result();
            $cols = "";
            foreach ($coulms as $col) {
                $cols .= $col->column_name . ",";
            }
            $cols = rtrim($cols, ",");
            $step2 = str_replace("%columns%", $cols, $step1);

            $cols_values = "";
            foreach ($coulms as $col) {
                $cols_values .= "OLD.$col->column_name" . ",";
            }
            $cols_values = rtrim($cols_values, ",");


            $step3 = str_replace("%columns_values%", $cols_values, $step2);
            //$this->db->query($step2);
            echo $step3;

            echo "<br>";
            $trigger1 = str_replace('%name%', $table->table_name, $trigger);
            $trigger2 = str_replace('%table%', $table->table_name, $trigger1);
            $trigger3 = str_replace('%name%', $table->table_name, $trigger2) . "\n";
            echo $trigger3;
            echo "<br>";
            echo "----------------------------------------------------<br>";
            $this->db->query($step3);
            $this->db->query($trigger3);
        }
    }

    public function indexUpdates() {
        $query = "select * from    information_schema.tables where table_type='BASE TABLE' and table_schema='public'";

        $tables = $this->db->query($query)->result();
	
        foreach ($tables as $table) {
			if(($table->table_name=='generalcode') || ($table->table_name=='ci_sessions')){
				continue;
			}

            $template = "CREATE OR REPLACE FUNCTION %name%_update() RETURNS trigger AS \$BODY\$ "
                    . " BEGIN"
                    . " INSERT INTO "
                    . " updates.%table%_updates(%columns%,update_date_time_timestamp) VALUES(%columns_values%,current_timestamp); "
                    . "RETURN NEW; END;"
                    . "\$BODY\$ "
                    . " LANGUAGE plpgsql VOLATILE
                        COST 100;";

            $trigger = "CREATE TRIGGER %name%_update
                        BEFORE UPDATE
                        ON %table%
                        FOR EACH ROW
                        EXECUTE PROCEDURE %name%_update();";

            $step0 = str_replace('%name%', $table->table_name, $template);
            $step1 = str_replace('%table%', $table->table_name, $step0);

            $query = "SELECT  * FROM information_schema.columns WHERE table_schema = 'public' AND table_name='$table->table_name'";
            $coulms = $this->db->query($query)->result();
            $cols = "";
            foreach ($coulms as $col) {
                $cols .= $col->column_name . ",";
            }
            $cols = rtrim($cols, ",");
            $step2 = str_replace("%columns%", $cols, $step1);

            $cols_values = "";
            foreach ($coulms as $col) {
                $cols_values .= "OLD.$col->column_name" . ",";
            }
            $cols_values = rtrim($cols_values, ",");


            $step3 = str_replace("%columns_values%", $cols_values, $step2);
            //$this->db->query($step2);
            echo $step3;

            echo "<br>";
            $trigger1 = str_replace('%name%', $table->table_name, $trigger);
            $trigger2 = str_replace('%table%', $table->table_name, $trigger1);
            $trigger3 = str_replace('%name%', $table->table_name, $trigger2) . "\n";
            echo $trigger3;
            echo "<br>";
            echo "----------------------------------------------------<br>";
            $this->db->query($step3);
            $this->db->query($trigger3);
        }
    }

    public function createTableDeletes() {

        $query = "SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE'";
        $tables = $this->db->query($query)->result();
        $this->db->query("create schema deletes");
        foreach ($tables as $table) {
			if(($table->table_name=='generalcode') || ($table->table_name=='ci_sessions')){
				continue;
			}
            $template = "CREATE TABLE deletes.$table->table_name" . "_updates(%structure%,update_date_time_timestamp timestamp);";
            $query = "SELECT  * FROM information_schema.columns WHERE table_schema = 'public' AND table_name='$table->table_name'";
            $coulms = $this->db->query($query)->result();
            $colDatas = "";
            foreach ($coulms as $col) {
                $q = "select column_name, data_type,character_maximum_length from    information_schema.columns where table_name ='$table->table_name'"
                        . "and column_name='$col->column_name'";

                $colSpecific = $this->db->query($q)->result();

                foreach ($colSpecific as $colData) {
                    if ($colData->data_type == "character varying") {
                        $colDatas .= $col->column_name . " $colData->data_type($colData->character_maximum_length),";
                    } else {
                        $colDatas .= $col->column_name . " $colData->data_type,";
                    }
                }
            }

            $colDatas = rtrim($colDatas, ",");

            $final = str_replace("%structure%", $colDatas, $template);
            $this->db->query($final);
        }
    }

    public function createTableUpdates() {
        $this->db->query("create schema updates");
        $query = "SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE'";
        $tables = $this->db->query($query)->result();
        foreach ($tables as $table) {
			if(($table->table_name=='generalcode') || ($table->table_name=='ci_sessions')){
				continue;
			}
            $template = "CREATE TABLE updates.$table->table_name" . "_updates(%structure%,update_date_time_timestamp timestamp);";
            $query = "SELECT  * FROM information_schema.columns WHERE table_schema = 'public' AND table_name='$table->table_name'";
            $coulms = $this->db->query($query)->result();
            $colDatas = "";
            foreach ($coulms as $col) {
                $q = "select column_name, data_type,character_maximum_length from    information_schema.columns where table_name ='$table->table_name'"
                        . "and column_name='$col->column_name'";

                $colSpecific = $this->db->query($q)->result();

                foreach ($colSpecific as $colData) {
                    if ($colData->data_type == "character varying") {
                        $colDatas .= $col->column_name . " $colData->data_type($colData->character_maximum_length),";
                    } else {
                        $colDatas .= $col->column_name . " $colData->data_type,";
                    }
                }
            }

            $colDatas = rtrim($colDatas, ",");

            $final = str_replace("%structure%", $colDatas, $template);
            $this->db->query($final);
        }
    }

}
