<?php
function register_acf_block_types()
{
  if (function_exists("acf_register_block_type")) {
    // directory path for block templates
    $template_dir = get_template_directory() . "/blocks/";

    // check if directory exists
    if (is_dir($template_dir)) {
      // blocks.json file path
      $blocks_json_path = $template_dir . "blocks.json";

      // read the blocks.json file contents
      $blocks_json = file_get_contents($blocks_json_path);

      // decode the JSON data into an associative array
      $blocks_data = json_decode($blocks_json, true);

      // get all directories in the block templates directory
      $block_dirs = array_filter(glob($template_dir . "*"), "is_dir");

      // loop through block directories
      foreach ($block_dirs as $block_dir) {
        // block name
        $block_name = basename($block_dir);
        if (!isset($blocks_data[$block_name])||
          (isset($blocks_data[$block_name]["status"]) &&
            $blocks_data[$block_name]["status"] === false)
        ) {
          continue;
        }

        // block title

        $block_title = ucwords(str_replace("_", " ", $block_name));

        // register block type

        acf_register_block_type([
          "name" => $block_name,
          "title" => $blocks_data[$block_name]["title"] ?: __($block_title),
          "description" => __($block_title . " description"),
          "template_directory_uri" => get_template_directory_uri(),
          "stylesheet_directory_uri" => get_stylesheet_directory_uri(),
          "render_template" => "blocks/" . $block_name . "/index.php",
          "category" => $blocks_data[$block_name]["category"] ?? "text",
          "icon" => "admin-appearance",
          "supports" => ["anchor" => true, 'jsx'=>$block_name == "work_collapse_block"],
          "mode" => "preview",
          "example" => [
            "attributes" => [
              "mode" => "preview",
              "data" => ["is_screenshot" => true],
            ],
          ],
        ]);
      }
    }
  }
}
add_action("acf/init", "register_acf_block_types");