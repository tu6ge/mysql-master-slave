<?php
sleep(30);

$master_db = parse_url($_ENV['MASTER_DB_LINK']);
$master_db['port'] = $master['port']?:3306;
$mysqli = new mysqli($master_db['host'].':'.$master_db['port'], $master_db['user'], $master_db['pass']);

$password = getUuid();
$mysqli->query("GRANT REPLICATION SLAVE ON *.* to 'backup'@'%' identified by '".$password."';");
#echo $mysqli->error;
#die;

$sql = "show master status";    
$result = $mysqli->query($sql);    

$binInfo = [];   
if ($result){
        while ($binInfo = $result->fetch_assoc()) {    
            break;    
        }//end while()    
}
if(empty($binInfo)){
	die("not found master status");
}
#print_r($binInfo);
#die;
$slave_links = $_ENV['SLAVE_DB_LINKS'];
$slave_links_rs = explode('|', $slave_links);
foreach($slave_links_rs as $val){
	$urlInfo = parse_url($val);
	$urlInfo['port'] = $urlInfo['port']?:3306;
	$s_mysqli = new mysqli($urlInfo['host'], $urlInfo['user'], $urlInfo['pass']);
	$s_mysqli->query("change master to master_host='".$master_db['host']."',master_user='backup',master_password='".$password."', master_log_file='".$binInfo['File']."',master_log_pos=".$binInfo['Position'].",master_port=".$master_db['port'].";");

	$s_mysqli->query("start slave;");

	sleep(2);

	$slave_result = $s_mysqli->query("show slave status");
	$slaveInfo = [];
	if($slave_result){
		while( $slaveInfo = $slave_result->fetch_assoc()){
			break;
		}	
	}
	echo "slave ".$urlInfo['host'].' status '.$slaveInfo['Slave_IO_State']."\n";
}
function getUuid()
{
    return strtoupper(md5(uniqid(md5(mt_rand()),true)));
}
