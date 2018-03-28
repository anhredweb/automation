﻿DROP TABLE AUTOMATION_TEST_CASE_PL;
CREATE TABLE AUTOMATION_TEST_CASE_PL
(
       /* Data need defined to run automation testing */
       product_group                             VARCHAR2(50)  NOT NULL,
       product_scheme                            VARCHAR2(50)  NOT NULL,
       dsa_code                                  VARCHAR2(50)  NOT NULL,
       gender                                    VARCHAR2(1)   NOT NULL,
       national_id                               VARCHAR2(20)  NOT NULL,
       date_of_birth                             DATE          NOT NULL,
       fb_number                                 VARCHAR2(30),
       phone                                     VARCHAR2(12)  NOT NULL,
       hometown                                  VARCHAR2(100),
       disbursement_channel                      VARCHAR2(30),
       requested_amount                          NUMBER(18,4)  NOT NULL,
       tenor                                     NUMBER(2)     NOT NULL,
       loan_purpose                              VARCHAR2(30),
       is_fb_owner                               VARCHAR2(1)   NOT NULL,
       education                                 NUMBER(3),
       marital_status                            VARCHAR2(1)   NOT NULL,
       social_status                             NUMBER(3),
       comp_tax_code                             VARCHAR2(80)
       year_in_curr_job                          NUMBER(2),
       personal_income                           NUMBER(18,4),
       family_income                             NUMBER(18,4),
       phone_reference1                          VARCHAR2(12),
       phone_reference2                          VARCHAR2(12),
       cic_description                           VARCHAR2(200),
       pcb_description                           VARCHAR2(4000),
       number_of_rel_cic                         VARCHAR2(5),
       number_of_rel_pcb                         VARCHAR2(5),
       /* Data will fill after automation run */
       application_id                            VARCHAR2(20),
       case_id                                   VARCHAR2(10),
       total_score                               NUMBER(10)    NOT NULL,
       score_group                               VARCHAR2(5)   NOT NULL,
       product_score_group                       VARCHAR2(5)   NOT NULL,
       sub_segment                               VARCHAR(10)   NOT NULL,
       lead_black                                VARCHAR(10)   NOT NULL,
       /* Scores are defined by user */
       score_user_age                            NUMBER(3)     NOT NULL,
       score_user_cic_relationship               NUMBER(3)     NOT NULL,
       score_user_company                        NUMBER(3)     NOT NULL,
       score_user_pre_of_work_exp                NUMBER(3)     NOT NULL,
       score_user_cust_social_trust              NUMBER(3)     NOT NULL,
       score_user_disb_apps                      NUMBER(3)     NOT NULL,
       score_user_dsa                            NUMBER(3)     NOT NULL,
       score_user_education                      NUMBER(3)     NOT NULL,
       score_user_gender                         NUMBER(3)     NOT NULL,
       score_user_marital_status                 NUMBER(3)     NOT NULL,
       score_user_hometown                       NUMBER(3)     NOT NULL,
       score_user_rejected_apps                  NUMBER(3)     NOT NULL,
       score_user_ts_apply_days                  NUMBER(3)     NOT NULL,
       /* Scores will fill after automation run by robot */
       score_robot_age                           NUMBER(3),
       score_robot_cic_relationship              NUMBER(3),
       score_robot_company                       NUMBER(3),
       score_robot_pre_of_work_exp               NUMBER(3),
       score_robot_cust_social_trust             NUMBER(3),
       score_robot_disb_apps                     NUMBER(3),
       score_robot_dsa                           NUMBER(3),
       score_robot_education                     NUMBER(3),
       score_robot_gender                        NUMBER(3),
       score_robot_marital_status                NUMBER(3),
       score_robot_hometown                      NUMBER(3),
       score_robot_rejected_apps                 NUMBER(3),
       score_robot_ts_apply_days                 NUMBER(3),
       robot_total_score                         NUMBER(3),
       robot_score_group                         VARCHAR2(5),
       robot_product_score_group                 VARCHAR2(5),
       robot_sub_segment                         VARCHAR(10),
       robot_lead_black                          VARCHAR(10),
       /* Checking score */
       score_check_age                           VARCHAR2(2),
       score_check_cic_relationship              VARCHAR2(2),
       score_check_company                       VARCHAR2(2),
       score_check_pre_of_work_exp               VARCHAR2(2),
       score_check_cust_social_trust             VARCHAR2(2),
       score_check_disb_apps                     VARCHAR2(2),
       score_check_dsa                           VARCHAR2(2),
       score_check_education                     VARCHAR2(2),
       score_check_gender                        VARCHAR2(2),
       score_check_marital_status                VARCHAR2(2),
       score_check_hometown                      VARCHAR2(2),
       score_check_rejected_apps                 VARCHAR2(2),
       score_check_ts_apply_days                 VARCHAR2(2),
       check_total_score                         VARCHAR2(2),
       check_score_group                         VARCHAR2(2),
       check_product_score_group                 VARCHAR2(2),
       check_sub_segment                         VARCHAR2(2),
       check_lead_black                          VARCHAR2(2),
       /* Checking status */
       is_run                                    NUMBER(1)     DEFAULT 0,
       status                                    NUMBER(1)     DEFAULT 0
);

INSERT ALL 
INTO AUTOMATION_TEST_CASE_PL
(
       product_group,
       product_scheme,
       dsa_code,
       gender,
       national_id,
       date_of_birth,
       fb_number,
       phone,
       hometown,
       disbursement_channel,
       requested_amount,
       tenor,
       loan_purpose,
       is_fb_owner,
       education,
       marital_status,
       social_status,
       comp_tax_code,
       year_in_curr_job,
       personal_income,
       family_income,
       phone_reference1,
       phone_reference2,
       cic_description,
       pcb_description,
       number_of_rel_cic,
       number_of_rel_pcb,
       total_score,
       score_group,
       product_score_group,
       sub_segment,
       lead_black,
       score_user_age,
       score_user_cic_relationship,
       score_user_company,
       score_user_pre_of_work_exp,
       score_user_cust_social_trust,
       score_user_disb_apps,
       score_user_dsa,
       score_user_education,
       score_user_gender,
       score_user_marital_status,
       score_user_hometown,
       score_user_rejected_apps,
       score_user_ts_apply_days
)
VALUES
(
       'NEW TO BANK',
       'UP CAT C - 306',
       'BAD00001',
       'F',
       201712081057,
       TO_DATE('11/11/1994', 'DD/MM/YYYY'),
       'FB#201712081057',
       '0912081057',
       'Hồ Chí Minh',
       'VNPOST',
       19000000,
       7,
       'Other',
       'Y',
       76,
       'O',
       8,
       '000-000-111-999',
       4,
       35000000,
       45000000,
       '0912081058',
       '0912081059',
       'CIC CANNOT CHECK',
       'Tên khách hàng : MAI VĂN TOÀN
       Số chứng minh nhân dân : 381458301
       Địa chỉ thường trú hiện tại : ẤP RẠCH MUỖI,01235013992,PHÚ HƯNG,H.CÁI NƯỚC,CÀ MAU
       Địa chỉ tạm trú hiện tại : . . RẠCH MUỖI PHÚ HƯNG CÁI NƯỚC TỈNH CÀ MAU
       Số lượng TCTD mà KH có dư nợ thông thường - thấu chi : Không có quan hệ tại TCTD
       Số lượng TCTD mà KH có dư nợ thẻ tín dụng : Không có quan hệ tại TCTD
       Số lượng TCTD mà KH đang có yêu cầu vay : 3
       Dư nợ hiện tại : 
       Nhóm nợ cao nhất hiện tại : 
       Nhóm nợ cao nhất trong vòng 5 năm : 1 - Nợ đủ tiêu chuẩn',
       'R2',
       'R3',
       0,
       0,
       0,
       'NTB_S1',
       'FALSE',
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0
)
INTO AUTOMATION_TEST_CASE_PL
(
       product_group,
       product_scheme,
       dsa_code,
       gender,
       national_id,
       date_of_birth,
       fb_number,
       phone,
       hometown,
       disbursement_channel,
       requested_amount,
       tenor,
       loan_purpose,
       is_fb_owner,
       education,
       marital_status,
       social_status,
       comp_tax_code,
       year_in_curr_job,
       personal_income,
       family_income,
       phone_reference1,
       phone_reference2,
       cic_description,
       pcb_description,
       number_of_rel_cic,
       number_of_rel_pcb,
       total_score,
       score_group,
       product_score_group,
       sub_segment,
       lead_black,
       score_user_age,
       score_user_cic_relationship,
       score_user_company,
       score_user_pre_of_work_exp,
       score_user_cust_social_trust,
       score_user_disb_apps,
       score_user_dsa,
       score_user_education,
       score_user_gender,
       score_user_marital_status,
       score_user_hometown,
       score_user_rejected_apps,
       score_user_ts_apply_days
)
VALUES
(
       'NEW TO BANK',
       'UP CAT C - 306',
       'BAD00002',
       'M',
       201712081100,
       TO_DATE('11/11/1994', 'DD/MM/YYYY'),
       'FB#201712081100',
       '0912081100',
       'Hồ Chí Minh',
       'VNPOST',
       20000000,
       6,
       'Other',
       'N',
       76,
       'M',
       8,
       '000-000-111-999',
       4,
       35000000,
       45000000,
       '0912081101',
       '0912081102',
       'CIC CANNOT CHECK',
       'Tên khách hàng : NGUYỄN THỊ DIỄM THÚY
       Số chứng minh nhân dân : 280708925
       Địa chỉ thường trú hiện tại : TỔ 7 . ẤP CÂY SẮN XÃ LAI UYÊN BÀU BÀNG TỈNH BÌNH DƯƠNG
       Địa chỉ tạm trú hiện tại : TỔ 7 . ẤP CÂY SẮN XÃ LAI UYÊN BÀU BÀNG TỈNH BÌNH DƯƠNG
       Số lượng TCTD mà KH có dư nợ thông thường - thấu chi : 1
       Số lượng TCTD mà KH có dư nợ thẻ tín dụng : Không có quan hệ tại TCTD
       Số lượng TCTD mà KH đang có yêu cầu vay : Không có quan hệ tại TCTD
       Dư nợ hiện tại : 328.000
       Nhóm nợ cao nhất hiện tại : Nợ nhóm 6 - nợ xấu
       Nhóm nợ cao nhất trong vòng 5 năm : Nợ nhóm 6 - nợ xấu',
       'R4',
       'R5'
       0,
       0,
       0,
       'NTB_S2',
       'TRUE',
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0,
       0
)
SELECT 1 
FROM DUAL;

SELECT * 
FROM AUTOMATION_TEST_CASE_PL
FOR UPDATE;