<footer>
    <div class="container">
        <div class="row">
            <!--  Information -->
            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                <h3>Information</h3>
                <ul>
                    <li><a href="Qui_sommes-nous?">Qui sommes-nous ?</a></li>
                    <li><a href="../Contact">Me contacter via formulaire</a></li>
                </ul>
            </div>
            <!-- Vous êtes perdu ? -->
            <div class="col-lg-5">
                <h3>Vous êtes perdu ?</h3>
                <ul>
                    <li><a href="glossary">Glossaire</a></li>
                    <li><a href="sitemap">Plan du site</a></li>
                </ul>
            </div>
            <?php if (isset($readUsers->id_cuyn_admin) && $readUsers->id_cuyn_admin == 1) { ?>
                <div class="col-lg-2">
                    <h3>Administration</h3>
                    <ul>
                        <li><a href="../admin/view.php">Partie administration</a></li>
                        <?php if (isset($readUsers->id_cuyn_admin) && $readUsers->id_cuyn_admin == 1 || $readUsers->id_cuyn_admin == 2) { ?>
                            <li><a href="../admin/newsWritingView.php">Ajouter un article</a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</footer>
<!-- Les Script Jquery, Bootstrap, Font awesome et le script js -->
<script src="../assets/lib/jquery/dist/jquery.min.js"></script>
<script src="../assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>
