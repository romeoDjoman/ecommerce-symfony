Mailer 
https://www.youtube.com/watch?v=JORoegP0OqU
https://www.youtube.com/watch?v=aSFREcYh8N8



    Pour redimensionner l'image à une taille spécifique (470x600) dans Symfony, 
    vous pouvez utiliser le bundle LiipImagineBundle. Voici comment vous pouvez le faire :
    Installation du Bundle : composer require liip/imagine-bundle

    Configuration du Bundle :
    Ajoutez la configuration nécessaire dans config/packages/liip_imagine.yaml :

    liip_imagine:
        resolvers:
            default:
                web_path: ~

        filter_sets:
            my_thumb:
                quality: 75
                filters:
                    thumbnail: { size: [470, 600], mode: outbound }

    Utilisation dans votre template Twig :
    <div class="product__modal-img product__thumb w-img">
        <img src="{{ asset('assets/upload/products/' ~ product.imageProduct) | imagine_filter('my_thumb') }}" alt="">
        <div class="product__sale">
            <span class="new">new</span>
            <span class="percent">-16%</span>
        </div>
    </div>

