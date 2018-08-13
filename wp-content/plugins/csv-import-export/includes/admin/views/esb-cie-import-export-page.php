<?php

/**
 * Settings Page
 * Handles to settings
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
    
    <h2><?php _e( 'CSV Import - Export', 'esbcie' ); ?></h2>
    
    <?php
    
        $current = 'post';
        $tabs = esb_cie_post_type_tabs();
        
        if( isset( $_GET['cie_import'] ) || isset( $_GET['cie_update'] ) || isset( $_GET['cie_ignore'] ) ) {
            
            $item_name    = !empty( $_GET['cie_type'] ) ? ( $_GET['cie_type'] == 'term' ? __( 'categories', 'esbcie' ) : __( 'posts', 'esbcie' ) ) : __( 'items', 'esbcie' );
            $total_import = !empty( $_GET['cie_import'] ) ? $_GET['cie_import'] : 0;
            $total_update = !empty( $_GET['cie_update'] ) ? $_GET['cie_update'] : 0;
            $total_ignore = !empty( $_GET['cie_ignore'] ) ? $_GET['cie_ignore'] : 0;
            
            echo "<div class='updated below-h2'>
                    <p><strong>{$total_import}</strong> {$item_name} was successfully imported. <strong>{$total_update}</strong> {$item_name} updated. <strong>{$total_ignore}</strong> {$item_name} ignored.</p>
                </div>";
        }
        
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ) {
            $class = ( $tab == $current ) ? ' nav-tab-active ' : '';
            echo "<a class='nav-tab$class' href='#$tab'>$name</a>";
        }
        echo '</h2>';
      
    ?>

    <!-- beginning of the settings meta box -->
    <div id="esb_cie_settings" class="post-box-container">

        <div class="esb-cie-content">

            <?php foreach( $tabs as $tab => $name ) { ?>
            
                <div class="esb-cie-tab-content" id="<?php echo $tab ?>">
                    
                    <!-- Post Type View Start -->
                    <div class="metabox-holder">	
                        <div class="meta-box-sortables ui-sortable">
                            <div id="esb_cie_<?php echo $tab ?>" class="postbox">

                                <!-- settings box title -->
                                <h3 class="hndle">
                                    <span style='vertical-align: top;'><?php echo $name; ?></span>
                                </h3>

                                <div class="inside">

                                    <!-- CSV description Start -->
                                    <table class="form-table esb-cie-form-table">

                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'CSV description', 'esbcie' ); ?></strong>
                                            </td>
                                        </tr>

                                    </table>

                                    <?php
                                        $all_options = esb_cie_get_all_post_fields();
                                        if( !empty( $all_options ) ) {
                                    ?>
                                    <form method="post">
                                        <table class="widefat importers esb-cie-importers">
                                            <thead>
                                                <tr>
                                                    <th class="cb"></th>
                                                    <th><strong><?php _e( 'ATTRIBUTE', 'esbcie' ) ?></strong></th>
                                                    <th><strong><?php _e( 'COLUMN NAME', 'esbcie' ) ?></strong></th>
                                                    <th><strong><?php _e( 'NOTICE', 'esbcie' ) ?></strong></th>
                                                </tr>
                                            </thead>
                                    <?php
                                        $taxonomies = esb_cie_get_all_taxonomies( $tab );
                                        if( !empty( $taxonomies ) ) {
                                            /*foreach( $taxonomies as $key => $taxonomy ) {
                                                $menu_title = !empty( $taxonomy->labels ) && !empty( $taxonomy->labels->menu_name ) ? $taxonomy->labels->menu_name : $taxonomy->label;
                                                $all_options[] = array(
                                                                            'key'   => 'tax-'.$key,
                                                                            'label' => $menu_title,
                                                                            'notice'=> __( 'Comma separated list of categories names (slugs) (e.g. cat1,cat2)', 'esbcie' )
                                                                        );
                                            }*/
                                        }

                                        $all_options[] = array(
                                            'key'   => 'style_no',
                                            'label' => "Style Number",
                                            'notice'=> __( 'Style Number', 'esbcie' )
                                        );
                                        $all_options[] = array(
                                            'key'   => 'tags',
                                            'label' => "Tags",
                                            'notice'=> __( 'Comma separated list of tags', 'esbcie' )
                                        );
                                        $all_options[] = array(
                                            'key' => 'post_date',
                                            'label' => "Post Date",
                                            'notice' => __( 'Date for post-creation', 'esbcie')
                                        );
                                        foreach ( $all_options as $opt => $option_data ) {

                                            $row_class = ( $opt % 2 == 0 ) ? ' alternate ' : '';
                                            $key    = isset( $option_data['key'] ) ? $option_data['key'] : '';
                                            $label  = isset( $option_data['label'] ) ? $option_data['label'] : '';
                                            $notice = isset( $option_data['notice'] ) ? $option_data['notice'] : '';
                                    ?>
                                            <tr class="<?php echo $row_class ?>">
                                                <td><input type="checkbox" id="esb_cie_<?php echo $key ?>_<?php echo $tab ?>" name="esb_cie_column_name[]" value="<?php echo $key ?>" checked="checked" /></td>
                                                <td class="row-title"><label for="esb_cie_<?php echo $key ?>_<?php echo $tab ?>"><?php echo $label ?></label></td>
                                                <td><code><?php echo $key ?></code></td>
                                                <td><span class="description"><?php echo $notice ?></span></td>
                                            </tr>
                                    <?php } ?>
                                        </table>
                                        <p>
                                            <input type="hidden" name="esb_cie_csv_file_name" value="<?php echo $name ?>" />
                                            <input type="hidden" name="esb_cie_export_post_type" value="<?php echo $tab ?>" />
                                            <input type="submit" name="esb_cie_export_posts_csv" class="button-secondary" value="<?php _e( 'Export CSV', 'esbcie' ) ?>" />
                                            <input type="submit" name="esb_cie_download_sample_csv" class="button-secondary" value="<?php _e( 'Download Sample CSV', 'esbcie' ) ?>" />
                                        </p>
                                    </form>
                                    <?php } ?>
                                    <!-- CSV description End -->
                                    
                                    <!-- Import from file Start -->
                                    <table class="form-table esb-cie-form-table">

                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Import from file', 'esbcie' ); ?></strong>
                                            </td>
                                        </tr>

                                    </table>
                                    
                                    <form method="post" enctype="multipart/form-data">
                                        <table class="widefat importers esb-cie-importers">
                                            <tr class="alternate">
                                                <td class="cb"><input type="radio" id="esb_cie_post_new" name="esb_cie_import_choice" value="new" checked="checked" /></td>
                                                <td><label for="esb_cie_post_new"><?php _e( 'Rename item\'s name (slug) if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb"><input type="radio" id="esb_cie_post_update" name="esb_cie_import_choice" value="update" /></td>
                                                <td><label for="esb_cie_post_update"><?php _e( 'Update old item\'s data if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                            <tr class="alternate">
                                                <td class="cb"><input type="radio" id="esb_cie_post_ignore" name="esb_cie_import_choice" value="ignore" /></td>
                                                <td><label for="esb_cie_post_ignore"><?php _e( 'Ignore item if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                        </table>
                                        <p>
                                            <input type="hidden" name="esb_cie_csv_post_type_name" value="<?php echo $tab ?>" />
                                            <input type="file" name="esb_cie_import_file" />
                                            <input type="submit" name="esb_cie_import_csv" class="button-secondary" value="<?php _e( 'Import From CSV', 'esbcie' ) ?>" />
                                        </p>
                                    </form>
                                    <!-- Import from file End -->

                                </div><!-- .inside -->

                            </div><!-- #settings -->
                        </div><!-- .meta-box-sortables ui-sortable -->
                    </div><!-- .metabox-holder -->
                    <!-- Post Type View End -->
                    
                <?php
                    $taxonomies = esb_cie_get_all_taxonomies( $tab );
                    if( !empty( $taxonomies ) ) {
                        foreach( $taxonomies as $taxonomy_key => $taxonomy ) {
                            $menu_title = !empty( $taxonomy->labels ) && !empty( $taxonomy->labels->menu_name ) ? $taxonomy->labels->menu_name : $taxonomy->label;
                ?>
                    <!-- Taxonomy View Start -->
                    <div class="metabox-holder">	
                        <div class="meta-box-sortables ui-sortable">
                            <div id="esb_cie_<?php echo $tab ?>_<?php echo $taxonomy_key ?>" class="postbox">

                                <!-- settings box title -->
                                <h3 class="hndle">
                                    <span style='vertical-align: top;'><?php echo $menu_title; ?></span>
                                </h3>

                                <div class="inside">

                                    <!-- CSV description Start -->
                                    <table class="form-table esb-cie-form-table">

                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'CSV description', 'esbcie' ); ?></strong>
                                            </td>
                                        </tr>

                                    </table>

                                    <?php
                                        $all_options = esb_cie_get_all_term_fields();
                                        if( !empty( $all_options ) ) {
                                    ?>
                                    <form method="post">
                                        <table class="widefat importers esb-cie-importers">
                                            <thead>
                                                <tr>
                                                    <th class="cb"></th>
                                                    <th><strong><?php _e( 'ATTRIBUTE', 'esbcie' ) ?></strong></th>
                                                    <th><strong><?php _e( 'COLUMN NAME', 'esbcie' ) ?></strong></th>
                                                    <th><strong><?php _e( 'NOTICE', 'esbcie' ) ?></strong></th>
                                                </tr>
                                            </thead>
                                    <?php
                                        if( isset( $taxonomy->hierarchical ) && $taxonomy->hierarchical == '1' ) {
                                            
                                            $all_options[] = array(
                                                                    'key'       => 'parent',
                                                                    'label'     => __( 'Parent Category', 'esbcie' ),
                                                                    'notice'    => __( 'Parent category name (slug)', 'esbcie' )
                                                            );
                                        }
                                        foreach ( $all_options as $opt => $option_data ) {

                                            $row_class = ( $opt % 2 == 0 ) ? ' alternate ' : '';
                                            $key    = isset( $option_data['key'] ) ? $option_data['key'] : '';
                                            $label  = isset( $option_data['label'] ) ? $option_data['label'] : '';
                                            $notice = isset( $option_data['notice'] ) ? $option_data['notice'] : '';
                                    ?>
                                            <tr class="<?php echo $row_class ?>">
                                                <td><input type="checkbox" id="esb_cie_<?php echo $key ?>_<?php echo $tab ?>" name="esb_cie_column_name[]" value="<?php echo $key ?>" checked="checked" /></td>
                                                <td class="row-title"><label for="esb_cie_<?php echo $key ?>_<?php echo $tab ?>"><?php echo $label ?></label></td>
                                                <td><code><?php echo $key ?></code></td>
                                                <td><span class="description"><?php echo $notice ?></span></td>
                                            </tr>
                                    <?php } ?>
                                        </table>
                                        <p>
                                            <input type="hidden" name="esb_cie_csv_file_name" value="<?php echo $menu_title ?>" />
                                            <input type="hidden" name="esb_cie_export_taxonomy" value="<?php echo $taxonomy_key ?>" />
                                            <input type="submit" name="esb_cie_export_terms_csv" class="button-secondary" value="<?php _e( 'Export CSV', 'esbcie' ) ?>" />
                                            <input type="submit" name="esb_cie_download_sample_csv" class="button-secondary" value="<?php _e( 'Download Sample CSV', 'esbcie' ) ?>" />
                                        </p>
                                    </form>
                                    <?php } ?>
                                    <!-- CSV description End -->
                                    
                                    <!-- Import from file Start -->
                                    <table class="form-table esb-cie-form-table">

                                        <tr>
                                            <td colspan="2" valign="top" scope="row">
                                                <strong><?php _e( 'Import from file', 'esbcie' ); ?></strong>
                                            </td>
                                        </tr>

                                    </table>
                                    
                                    <form method="post" enctype="multipart/form-data">
                                        <table class="widefat importers esb-cie-importers">
                                            <tr class="alternate">
                                                <td class="cb"><input type="radio" id="esb_cie_term_new" name="esb_cie_import_choice" value="new" checked="checked" /></td>
                                                <td><label for="esb_cie_term_new"><?php _e( 'Rename item\'s name (slug) if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb"><input type="radio" id="esb_cie_term_update" name="esb_cie_import_choice" value="update" /></td>
                                                <td><label for="esb_cie_term_update"><?php _e( 'Update old item\'s data if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                            <tr class="alternate">
                                                <td class="cb"><input type="radio" id="esb_cie_term_ignore" name="esb_cie_import_choice" value="ignore" /></td>
                                                <td><label for="esb_cie_term_ignore"><?php _e( 'Ignore item if item with name (slug) already exists', 'esbcie' ) ?></label></td>
                                            </tr>
                                        </table>
                                        <p>
                                            <input type="hidden" name="esb_cie_csv_taxonomy_name" value="<?php echo $taxonomy_key ?>" />
                                            <input type="file" name="esb_cie_import_file" />
                                            <input type="submit" name="esb_cie_import_term_csv" class="button-secondary" value="<?php _e( 'Import From CSV', 'esbcie' ) ?>" />
                                        </p>
                                    </form>
                                    <!-- Import from file End -->

                                </div><!-- .inside -->

                            </div><!-- #settings -->
                        </div><!-- .meta-box-sortables ui-sortable -->
                    </div><!-- .metabox-holder -->
                    <!-- Taxonomy View End -->
                    
                <?php
                        }
                    }
                ?>
                    
                </div><!-- .esb-cie-tab-content -->
            
            <?php } ?>

        </div><!-- .esb-cie-content -->

    </div><!-- #esb_cie_settings -->
</div>