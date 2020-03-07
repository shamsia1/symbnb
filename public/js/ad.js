  $('#add-image').click(function (){
            // je récupére le numero des futures champs que je vais créer
            const index = +$('#widgets-counter').val();

            // je récupére le prototype des entrees
            const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);


            //j'inject ce code au sein de la vie
            $('#ad_images').append(tmpl);

            $('#widgets-counter').val(index + 1);  

            //je gére le bouton supprimer
            handleDeleteButtons();

        });
        function handleDeleteButtons(){
            $('button[data-action="delete"]').click(function(){
                const target = this.dataset.target;
             
                $(target).remove(); 

            });
        }

        function unpdateCounter(){
        	const count = +$('#ad_images div.form-group').Length;
        	$('#widgets-counter').val(count);
        }


        handleDeleteButtons();
          