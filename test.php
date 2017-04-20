<?
	$alt = array("", "Blog", "Profile", "Project", "Lecture", "Comments", "Link");
	$link = array("", "index.html", "profile.html", "project.html", "lecture.html", "comments.html",
"link.html");
	$link_num = count($link) -1;

	for ($i=1; $i<=$link_num; $i++){
			echo "
				<li class=\"fl\"><a href=\"$link[$i]\"><img src=\"images/menu0$i.gif\"
name=\"menu0$i\" onMouseOut=\"menu0$i.src='images/menu0$i.gif';\"
onMouseOver=\"menu0$i.src='images/menu0$i", "_", "on.gif';\" /></a></li>
			";
		}
	}
?>