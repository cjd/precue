<?PHP
/*
media.inc
Purpose: establish a hash linking song id's to media filenames
Format: 
Path to media file is: $media_path
Filename is: $media['songid'];
*/
session_register(media_path);
$media_path = "media/";

session_register(media);
$media = array(
		'351' => 'bebold.mid',
		'131' => 'asthedeer.mid',
		'74' => 'ancientofdays.mid',
		'2147483647' => 'awayinamanger.mid',
		'3' => 'amazinggrace.mid',
		'223' => 'bestillforthepresence.mid',
		'71' => 'blessedassurance.mid',
		'110' => 'blessedbetherock.mid',
		'227' => 'crownhimwithmanycrowns.mid',
		'271' => 'fearnot.mid',
		'68' => 'forimbuildingapeopleofpower.mid',
		'306' => 'godwillmakeaway.mid',
		'103' => 'guidemeothougreatjehovah.mid',
		'48' => 'harktheheraldangelssing.mid',
		'11' => 'hehasmademeglad.mid',
		'150' => 'holyholyholy.mid',
		'169' => 'hosanna.mid',
		'342' => 'ibelieveinjesus.mid',
		'317' => 'icouldsingofyourloveforever.mid',
		'303' => 'iexaltthee.mid',
		'312' => 'immortalinvisiblegodonlywise.mid'
		
	);
?>