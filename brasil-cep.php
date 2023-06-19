<?php
/**
* Plugin Name:          Brasil CEP
* Plugin URI:           https://github.com/rafa-carmo/WordpressBrasilCep
* Description:          Preenche o endereço de um formulário baseado no CEP
* Author:               Rafael do carmo
* Author URI:           https://github.com/rafa-carmo
* Version:              0.1
*
* Preenche baseado no cep o endereço dos campos através do label dos campos.
*
*/

if(! defined("ABSPATH")) {
    die('Invalid Request');
}

class BrazilCepSearch {
    public function activate() {
        if(! get_option('cep_label') ) {
            add_option( 'cep_label', 'cep' );
            add_option( 'street_label', 'logradouro' );
            add_option( 'city_label', 'cidade' );
            add_option( 'state_label', 'estado' );
            add_option( 'neighborhood_label', 'bairro' );
        }
    }
    public function deactivate() {
        delete_option( 'cep_label', 'cep' );
        delete_option( 'street_label', 'logradouro' );
        delete_option( 'city_label', 'cidade' );
        delete_option( 'state_label', 'estado' );
        delete_option( 'neighborhood_label', 'bairro' );
    }
    public function uninstall() {}
}

function brasil_cep_config_page() {
    add_options_page(
        'Brasil Cep Configurações', 
        'Brasil Cep', 
        'manage_options', 
        'brasil-cep-config', 
        'render_brasil_cep_config_page' 
    );
}


function render_brasil_cep_config_page() {
    $file = __DIR__ . '/views/admin.php';
    include($file);
}


function add_config_add_input(string $name, string $label, string $size='small') {
    $option = get_option( $name );
    echo "
        <div  class='$size' > 
            <label for='brasil_cep_plugin_$name'> $label </label>
            <input id='brasil_cep_plugin_$name' name='$name' type='text'value='" . esc_attr( $option ) . "' />
        </div>
        ";
}


if (class_exists('BrazilCepSearch')) {
    $cepSearch = new BrazilCepSearch();
    add_action( 'admin_menu', 'brasil_cep_config_page' );

    wp_register_style( 'br-cep.css', plugin_dir_url( __FILE__ ) . '_inc/br-cep.css' );
    wp_enqueue_style( 'br-cep.css');

    
    wp_register_script( 'busca_cep', plugins_url( '/js/busca-cep.js', __FILE__ ), array( 'jquery' ), '1.0', true );

    wp_localize_script( 'busca_cep', 'names', array(
        'cep' => get_option( 'cep_label' ),
        'street' => get_option( 'street_label' ),
        'neighborhood' => get_option( 'neighborhood_label' ),
        'city' => get_option( 'city_label' ),
        'state' => get_option( 'state_label' ),
    ) );
    wp_enqueue_script( 'busca_cep' );

    register_activation_hook(__file__, array($cepSearch, 'activate'));
    register_deactivation_hook(__file__, array($cepSearch, 'deactivate'));
    register_uninstall_hook(__file__, array($cepSearch, 'uninstall'));
}
