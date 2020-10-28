<header class='header'>
                <nav class="nav">
                    <img  id="logo" src="Pngtree.png" />
                    <p>
                        <a class='link' href="form.html">me contacter</a>
                    </p>
                    <p>
                        <a class='link' href="#">acceuil</a>
                    </p>
                    <p>
                        <a class='link' href="https://meo.fr">Meo</a>
                    </p>
                    <p>
                        <a class='link' href="https://www.maxicoffee.com/">Maxicoffee</a>
                    </p>
                    <div id="like_button_container"></div>
                </nav>
                
            </header>
            <section class="post">
                <div class="space"></div>
                <h1>Tout sur le café!</h1>
            <?php for($i = 0;$i<$dCount;$i++){ ?>
            
                <article>
                    <p class="img-float">
                        <img src="images.jpg"/>
                    </p>
                    
                    <h2><?php echo $data[$i]->getTitre(); ?></h2>
                    <p>
                    <?php echo $data[$i]->getContenu(); ?>
                        
                    </p>
                </article>
            <?php } ?>
            </section>