"# ICYM-Karate-do-JoinHub" 

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
