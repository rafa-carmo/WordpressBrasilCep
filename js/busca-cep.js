jQuery(document).ready(function(){
    function limpa_formulário_cep() {
        setInput('rua', '')
        setInput('bairro', '')
        setInput('cidade', '')
        setInput('uf', '')
    }


    function getInputId(name) {
        const value = jQuery("label").filter((_, val) => val.innerText.toUpperCase() === name.toUpperCase())
        if(value.length > 0){
            return `#${value[0].getAttribute('for')}`
        }
    }

    function setInput(label, value) {
        const id = getInputId(label)
        jQuery(id).val(value)
    }

    jQuery(getInputId(names.cep)).blur(function() {
        let cep = jQuery(this).val().replace(/\D/g, '');

        if (cep != "" && cep.length > 7) {    
            const validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                jQuery.getJSON(`https://brasilapi.com.br/api/cep/v2/ ${cep}`, function(dados) {
                    if (dados && dados.street) {
                        setInput(names.street, dados.street)
                        setInput(names.neighborhood, dados.neighborhood)
                        setInput(names.city, dados.city)
                        setInput(names.state, dados.state)
                    }
                    else {
                        limpa_formulário_cep();
                    }
                });
            } 
            else {
                limpa_formulário_cep();
            }
        } 
        else {
            limpa_formulário_cep();
        }
    });
});