#!/usr/local/bin/php
<?php
// ranking.php for  in /home/simomb_s/bFanSports/dataBinding/php/responsiveTable
//
// Made by SIMO MBA
// Login   <simomb_s@epitech.net>
//
// Started on  Tue Nov 29 12:58:20 2016 SIMO MBA
// Last update Fri Dec  2 15:59:45 2016 SIMO MBA
//

require __DIR__.'/vendor/autoload.php';
include("template/template.class.php");

class Ranking
{
  var $head = array("PTS" => "PTS", "MJ" => "MJ", "VICT" => "VICT",
		    "NUL" => "NUL", "DEF" => "DÉF", "BUTS_P" => "BUTS POUR",
		    "BUTS_C" => "BUTS CONTRE", "BUT_P_D" => "BUTS POUR DOM",
		    "BUT_P_E" => "BUT POUR EXT", "BUT_C_D" => "BUT CONT DOM",
		    "BUT_C_E" => "BUT CONT EXT");

  var $xml;
  var $page;
  var $body;
  var $contents;

  function	__construct($url) {
    $this->page = file_get_contents($url);
  }

  function get_html_page() {
    $head_row = new Template("build/templates/init_head.tpl");
    foreach ($this->head as $key => $value) {
      $head_row->set($key, $value);
    }
    $this->xml = simplexml_load_string($this->page);
    $i = 0;
    while (isset($this->xml->equipe[$i])) {
      $body_col = new Template("build/templates/col.tpl");

      $body_col->set("num", (string)$this->xml->equipe[$i]->position);
      $body_col->set("src_img", (string)$this->xml->equipe[$i]->equipeLogo);
      $body_col->set("pays", (string)$this->xml->equipe[$i]->equipeNom);
      $body_col->set("PTS", (string)$this->xml->equipe[$i]->totalPoint);
      $body_col->set("MJ", (string)$this->xml->equipe[$i]->totalMatch);
      $body_col->set("VICT", (string)$this->xml->equipe[$i]->totalVictoire);
      $body_col->set("NUL", (string)$this->xml->equipe[$i]->totalNul);
      $body_col->set("DEF", (string)$this->xml->equipe[$i]->totalDefaite);
      $body_col->set("BUTS_POUR", (string)$this->xml->equipe[$i]->totalButPour);
      $body_col->set("BUTS_CONTRE", (string)$this->xml->equipe[$i]->totalButContre);
      $body_col->set("BUT_P_D", (string)$this->xml->equipe[$i]->totalButPourDomicile);
      $body_col->set("BUT_P_E", (string)$this->xml->equipe[$i]->totalButPourExterieur);
      $body_col->set("BUT_C_D", (string)$this->xml->equipe[$i]->totalButContreDomicile);
      $body_col->set("BUT_C_E", (string)$this->xml->equipe[$i]->totalButContreExterieur);

      $bodyColTemplate[] = $body_col;

      $i++;
    }

    $this->body = new Template("build/templates/ranking.tpl");
    $bodyContents = Template::merge($bodyColTemplate);
    $this->body->set("tab_head", $head_row->output());
    $this->body->set("tab_contents", $bodyContents);

    $this->contents = $this->body->output();

    $open = fopen("build/ranking.html", "w", true);
    fwrite($open, $this->contents);
    fclose($open);
    return ($this->contents);
  }

}

$ranking = new Ranking("http://lnh.fr/remote/equipes/creteil/xml_saisonClassement.xml");
$site = $ranking->get_html_page();
