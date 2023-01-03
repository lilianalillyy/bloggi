<?php declare(strict_types = 1);

namespace App\UI\Grid;

use Ublaboo\DataGrid\Localization\SimpleTranslator;

class GridTranslator extends SimpleTranslator
{
  public function __construct()
  {
    parent::__construct([
      "ublaboo_datagrid.no_item_found_reset" =>
        "Žádné položky nenalezeny. Filtr můžete vynulovat",
      "ublaboo_datagrid.no_item_found" => "Žádné položky nenalezeny.",
      "ublaboo_datagrid.here" => "zde",
      "ublaboo_datagrid.items" => "Položky",
      "ublaboo_datagrid.all" => "všechny",
      "ublaboo_datagrid.from" => "z",
      "ublaboo_datagrid.reset_filter" => "Resetovat filtr",
      "ublaboo_datagrid.group_actions" => "Hromadné akce",
      "ublaboo_datagrid.show_all_columns" => "Zobrazit všechny sloupce",
      "ublaboo_datagrid.hide_column" => "Skrýt sloupec",
      "ublaboo_datagrid.action" => "Akce",
      "ublaboo_datagrid.previous" => "Předchozí",
      "ublaboo_datagrid.next" => "Další",
      "ublaboo_datagrid.choose" => "Vyberte",
      "ublaboo_datagrid.execute" => "Provést",
    ]);
  }
}