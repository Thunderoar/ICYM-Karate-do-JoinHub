"# ICYM-Karate-do-JoinHub" 

changelog

view_plan.php = change deleted plan 'member deleted' to 'plan deleted'
nav.php = change 'view memeber' to 'view member'
view_plan.php = change 'months' to 'duration'
view_plan.php = change '₹' to 'RM'
new_plan.php = change change 'sports plan name' to 'plan name'
new_plan.php = change change 'sports plan description' to 'plan description'
new_plan.php = delete 'amount' and 'validity'
submit_new_plan.php = delete 'amount' and 'validity'
del_plan.php = establish an undeletable core plan 'MRBDPX'
revenue_month.php = change to
database = reframework
database = change log_users 'id' to 'logid'
database = change address 'id' to 'addressid'
database = add 'userid' as foreign key in address
database = change enrolls_to 'uid' to 'userid'
database = change plan 'pid' to 'planid'
database = change enrolls_to 'pid' to 'planid'
database = change log_users 'users_userid' to 'userid'
database = change log_users 'userid' to use VARCHAR(20)
database = change health_status 'hid' to 'healthid'
database = change plandetail.php 'pid' to 'planid'
database = change health_status 'uid' to 'userid'
database = change users' email varchar(20) to varchar(200)
database = change address' state AND city varchar(15) to varchar(40)
view_mem.php = change 'uid' to 'userid'
edit_member.php = change 'uid' to 'userid'
edit_member.php = fix sql querying
edit_mem_submit.php = change 'uid' to userid'
gen_invoice.php = fix sql querying
dashboard/admin/index.php = change timezone to 'Kuala_Lumpur'
view_plan.php = change 'pid' to 'planid'
dashboard/admin/index.php = change 'pid' to 'planid'

over_month.php = change 'id' to 'addressid'
payments.php = change 'pid' and 'uid' to 'planid' 'userid'
make_payments.php = change 'pid' to 'planid'
plandetail.php = remove 'Month' and change Rupee to RM
view_mem.php = use local js css files
add local js files = moment.min.js , jquery-3.4.1.min.js
new_entry.php = use local js files
payments.php = use local js css files
read_member.php = use local js css files
read_member.php = stylize table
gen_invoice.php = fix 'plaid' to 'planid'
new_health_status.php = fix 'uid' to 'userid'
health_status_entry.php = fix "uid' to 'userid
new_plan.php = remove 'sports'
revenue_month.php = stylize table
income_month.php = change Rupees to RM
income_month.php = remove Month
editroutine.php = stylize table
change_pwd.php = fix 'secert' typo to 'secret'
index.php = change Rupees to RM
over_members_month.php = use local css js files


addroutine.php = defaulted plan id to 'core' plan of 'BJEFSY'
nav.php = change to 'Planning' 'New Plan' 'Edit Plan'








extra info
nav.php = sidebar for admin panel

questions
how does admin add themselves?
how does staff get registered by admin?
how does member register themselves?
	= iya, page baru

how do people create 'core' plan?
	= delete button per didelete utk 'core' plan.
	= tk perlu admin utk bwtkan plan sbg 'core' plan


how do they assign and deassign?
in payment page, once paid, the 'add payment' button is no longer there.


GAMBAR KARATE

boleh tukar our coach, boleh letak instructor dekat sini
gallery





database:(DOUBT)
the 'Full_name' in admin database are just label, its not like 'access level'

et_id is not being handled gracefully(no use) in 'enrolls_to'. defaulted to current_timestamp()
UPDATE: et_id is id for enrolls_to

hid is not being handled gracefully(no use) in 'health_status'. defaulted to current_timestamp()
other attribute in 'health_status' are defaulted to blank through 'AS_DEFINED'.

relate primary key
userid = users(userid), health_status(uid), enrolls_to(uid), address(id)



INTERESTING ERROR
[Sun Sep 29 21:45:54.899360 2024] [php:error] [pid 77765] [client ::1:58024] PHP Fatal error:  Uncaught mysqli_sql_exception: Field 'validity' doesn't have a default value in /opt/lampp/htdocs/ICYMK/dashboard/admin/submit_plan_new.php:16\nStack trace:\n#0 /opt/lampp/htdocs/ICYMK/dashboard/admin/submit_plan_new.php(16): mysqli_query(Object(mysqli), 'insert into pla...')\n#1 {main}\n  thrown in /opt/lampp/htdocs/ICYMK/dashboard/admin/submit_plan_new.php on line 16, referer: http://localhost/ICYMK/dashboard/admin/new_plan.php
[Sun Sep 29 21:49:19.337682 2024] [php:error] [pid 78010] [client ::1:37190] PHP Fatal error:  Uncaught mysqli_sql_exception: Field 'et_id' doesn't have a default value in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php:33\nStack trace:\n#0 /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php(33): mysqli_query(Object(mysqli), 'insert into enr...')\n#1 {main}\n  thrown in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php on line 33, referer: http://localhost/ICYMK/dashboard/admin/new_entry.php

[Sun Sep 29 21:57:02.780243 2024] [php:error] [pid 78013] [client ::1:45822] PHP Fatal error:  Uncaught mysqli_sql_exception: Field 'hid' doesn't have a default value in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php:36\nStack trace:\n#0 /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php(36): mysqli_query(Object(mysqli), 'insert into hea...')\n#1 {main}\n  thrown in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php on line 36, referer: http://localhost/ICYMK/dashboard/admin/new_entry.php

[Sun Sep 29 22:00:31.929558 2024] [php:error] [pid 77766] [client ::1:57630] PHP Fatal error:  Uncaught mysqli_sql_exception: Field 'calorie' doesn't have a default value in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php:36\nStack trace:\n#0 /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php(36): mysqli_query(Object(mysqli), 'insert into hea...')\n#1 {main}\n  thrown in /opt/lampp/htdocs/ICYMK/dashboard/admin/new_submit.php on line 36, referer: http://localhost/ICYMK/dashboard/admin/new_entry.php
