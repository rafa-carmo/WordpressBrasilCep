<?php

//phpcs:disable VariableAnalysis
// There are "undefined" variables here because they're defined in the code that includes this file as a template.

?>

    <h2>Configurações de Brasil Cep</h2>
    <p>
        O Plugin busca pelo label referenciado ao input, digite o label de cada opção que ele ira preencher automaticamente.
    </p>
    <form method="post" class="form">
        <?php 
            if( count($_POST) > 0 ) {
                update_option( 'cep_label', $_POST['cep_label'] );
                update_option( 'street_label', $_POST['street_label'] );
                update_option( 'city_label', $_POST['city_label'] );
                update_option( 'state_label', $_POST['state_label'] );
                echo '<div class="notice notice-success"><p>Configurações salvas com sucesso.</p></div>';
            }
            add_config_add_input('cep_label', "Label do Cep");
            add_config_add_input('street_label', "Label do logradouro");
            add_config_add_input('city_label', "Label da Cidade");
            add_config_add_input('neighborhood_label', "Label do Bairro");
            add_config_add_input('state_label', "Label do Estado");
        ?>
        <button type="submit" class="button button-primary"><?php esc_attr_e( 'Save' ); ?></button>

    </form>