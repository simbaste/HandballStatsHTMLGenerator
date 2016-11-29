#!/usr/local/bin/php
<?php
// ranking.php for  in /home/simomb_s/bFanSports/dataBinding/php/responsiveTable
//
// Made by SIMO MBA
// Login   <simomb_s@epitech.net>
//
// Started on  Tue Nov 29 12:58:20 2016 SIMO MBA
// Last update Tue Nov 29 12:58:21 2016 SIMO MBA
//

include("template.class.php");

$head = array("PTS" => "PTS", "MJ" => "MJ", "VICT" => "VICT",
	      "NUL" => "NUL", "DEF" => "DÉF", "BUTS_P" => "BUTS POUR",
	      "BUTS_C" => "BUTS CONTRE", "BUT_P_D" => "BUTS POUR DOM",
	      "BUT_P_E" => "BUT POUR EXT", "BUT_C_D" => "BUT CONT DOM",
	      "BUT_C_E" => "BUT CONT EXT");

$head_row = new Template("init_head.tpl");

foreach ($head as $key => $value) {
  $head_row->set($key, $value);
}

$page = file_get_contents("http://lnh.fr/remote/equipes/creteil/xml_saisonClassement.xml");
$xml = simplexml_load_string($page);
$i = 0;
while (isset($xml->equipe[$i])) {
  $body_col = new Template("col.tpl");

  $body_col->set("num", (string)$xml->equipe[$i]->position);
  $body_col->set("src_img", (string)$xml->equipe[$i]->equipeLogo);
  $body_col->set("pays", (string)$xml->equipe[$i]->equipeNom);
  $body_col->set("PTS", (string)$xml->equipe[$i]->totalPoint);
  $body_col->set("MJ", (string)$xml->equipe[$i]->totalMatch);
  $body_col->set("VICT", (string)$xml->equipe[$i]->totalVictoire);
  $body_col->set("NUL", (string)$xml->equipe[$i]->totalNul);
  $body_col->set("DEF", (string)$xml->equipe[$i]->totalDefaite);
  $body_col->set("BUTS_POUR", (string)$xml->equipe[$i]->totalButPour);
  $body_col->set("BUTS_CONTRE", (string)$xml->equipe[$i]->totalButContre);
  $body_col->set("BUT_P_D", (string)$xml->equipe[$i]->totalButPourDomicile);
  $body_col->set("BUT_P_E", (string)$xml->equipe[$i]->totalButPourExterieur);
  $body_col->set("BUT_C_D", (string)$xml->equipe[$i]->totalButContreDomicile);
  $body_col->set("BUT_C_E", (string)$xml->equipe[$i]->totalButContreExterieur);

  $bodyColTemplate[] = $body_col;

  $i++;
}

$body = new Template("ranking.tpl");
$bodyContents = Template::merge($bodyColTemplate);
$body->set("tab_head", $head_row->output());
$body->set("tab_contents", $bodyContents);

$contents = $body->output();

$open = fopen("ranking.html", "w");
fwrite($open, $contents);
fclose($open);
