-- drop tables of similar names
drop table Chitha_pattadar_view;
drop table View_jama_chitha_consistent;
drop table View_jama_chitha_non_consistent;
-- create actual views
CREATE or replace VIEW Chitha_pattadar_view
AS
SELECT     Chitha_Dag_Pattadar.Dist_code, Chitha_Dag_Pattadar.Subdiv_code, Chitha_Dag_Pattadar.Cir_code,
                      Chitha_Dag_Pattadar.Mouza_Pargona_code, Chitha_Dag_Pattadar.Lot_No, Chitha_Dag_Pattadar.Vill_townprt_code,
                      Chitha_Dag_Pattadar.Dag_no, Chitha_Dag_Pattadar.Pdar_ID, Chitha_Dag_Pattadar.Patta_No, Chitha_Dag_Pattadar.Patta_type_code,
                      Chitha_Dag_Pattadar.Dag_por_B, Chitha_Dag_Pattadar.Dag_por_K, Chitha_Dag_Pattadar.Dag_por_LC,
                      Chitha_Dag_Pattadar.Dag_por_G, Chitha_Dag_Pattadar.Dag_por_kr, Chitha_Dag_Pattadar.Pdar_land_n,
                      Chitha_Dag_Pattadar.Pdar_land_s, Chitha_Dag_Pattadar.Pdar_land_e, Chitha_Dag_Pattadar.Pdar_land_w,
                      Chitha_Dag_Pattadar.Pdar_land_map, Chitha_Dag_Pattadar.Pdar_land_acre, Chitha_Dag_Pattadar.Pdar_land_revenue,
                      Chitha_Dag_Pattadar.Pdar_land_localtax, Chitha_Dag_Pattadar.user_code, Chitha_Dag_Pattadar.date_entry,
                      Chitha_Dag_Pattadar.operation, Chitha_Dag_Pattadar.P_flag, Chitha_Dag_Pattadar.jama_yn, Chitha_Pattadar.Pdar_name,
                      Chitha_Pattadar.Pdar_father, Chitha_Pattadar.Pdar_add1, Chitha_Pattadar.Pdar_add2, Chitha_Pattadar.Pdar_add3,
                      Chitha_Pattadar.Pdar_pan_no, Chitha_Pattadar.Pdar_citizen_no, Chitha_Pattadar.Pdar_thumb_imp, Chitha_Pattadar.Pdar_photo,
                      Chitha_Pattadar.pdar_guard_reln, Chitha_Pattadar.f1_case_no, Chitha_Pattadar.f2_case_no, Chitha_Pattadar.o1_case_no,
                      Chitha_Pattadar.o2_case_no, Chitha_Pattadar.new_pdar_name
FROM         Chitha_Dag_Pattadar INNER JOIN
                      Chitha_Pattadar ON Chitha_Dag_Pattadar.Dist_code = Chitha_Pattadar.Dist_code AND
                      Chitha_Dag_Pattadar.Subdiv_code = Chitha_Pattadar.Subdiv_code AND
                      Chitha_Dag_Pattadar.Cir_code = Chitha_Pattadar.Cir_code AND
                      Chitha_Dag_Pattadar.Mouza_Pargona_code = Chitha_Pattadar.Mouza_Pargona_code AND
                      Chitha_Dag_Pattadar.Lot_No = Chitha_Pattadar.Lot_No AND
                      Chitha_Dag_Pattadar.Vill_townprt_code = Chitha_Pattadar.Vill_townprt_code AND
                      Chitha_Dag_Pattadar.Pdar_ID = Chitha_Pattadar.Pdar_ID AND Chitha_Dag_Pattadar.Patta_No = Chitha_Pattadar.Patta_No AND
                      Chitha_Dag_Pattadar.Patta_type_code = Chitha_Pattadar.Patta_type_code;
-- -----------------------------------------
CREATE or replace VIEW View_jama_chitha_consistent
AS
SELECT     Jama_Patta.dist_code, Jama_Patta.subdiv_code, Jama_Patta.cir_code, Jama_Patta.mouza_pargona_code, Jama_Patta.Lot_No,
                      Jama_Patta.vill_townprt_code, Jama_Patta.patta_type_code, Jama_Patta.patta_no, Jama_Patta.old_patta_no, Jama_Patta.m_flag,
                       Jama_Patta.m_count, Jama_Patta.user_code, Jama_Patta.entry_date, Jama_Patta.entry_mode
FROM         (SELECT     Dist_code, Subdiv_code, Cir_code, Mouza_Pargona_code, Lot_No, Vill_townprt_code,Patta_No,Patta_type_code
                       FROM          Chitha_Basic
                       GROUP BY Dist_code, Subdiv_code, Cir_code, Mouza_Pargona_code, Lot_No, Vill_townprt_code,Patta_No, Patta_type_code)
                      AS tmp_Chitha_basic INNER JOIN
                      Jama_Patta ON tmp_Chitha_basic.Dist_code = Jama_Patta.dist_code AND tmp_Chitha_basic.Subdiv_code = Jama_Patta.subdiv_code AND
                       tmp_Chitha_basic.Cir_code = Jama_Patta.cir_code AND tmp_Chitha_basic.Mouza_Pargona_code = Jama_Patta.mouza_pargona_code AND
                      tmp_Chitha_basic.Lot_No = Jama_Patta.Lot_No AND tmp_Chitha_basic.Vill_townprt_code = Jama_Patta.vill_townprt_code AND
                      tmp_Chitha_basic.Patta_type_code = Jama_Patta.patta_type_code AND tmp_Chitha_basic.Patta_No = Jama_Patta.patta_no;
-- ----------------------------------------------------
CREATE or replace VIEW View_jama_chitha_non_consistent
AS
SELECT * FROM Jama_Patta
EXCEPT
SELECT * FROM View_jama_chitha_consistent;