<?php
$data = $newsManager->showAllNews();
$dCount = count($data);
?>
<br/>
<h2 class="h2 blockquote-footer">modification de la base de données</h2><br/>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">auteur</th>
      <th scope="col">titre</th>
      <th scope="col">Contenu</th>
      <th scope="col">DateAjout</th>
      <th scope="col">DateModif</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    for($i = 0;$i<$dCount;$i++){?>
    <form action='/ocr2/submit-delete-news' method='POST'>
      <tr>
        <th scope="row"><?php echo $i+1 ?></th>
        <input type="text" name="id" style="display:none" value=<?php echo $data[$i]->getId();?>>
        <td name="auteur"><?php echo $data[$i]->getAuteur(); ?></td>
        <td name="titre"><?php echo $data[$i]->getTitre(); ?></td>
        <td name ="contenu"><?php echo $data[$i]->getContenu(); ?></td>
        <td><?php  echo $data[$i]->getDateAjout(); ?></td>
        <td><?php  echo $data[$i]->getDateModif(); ?></td> 
        <td>
          <div style="">
          
            <input type="text" name="id3" style="display:none" value=<?php echo $data[$i]->getId();?>>

            <input type="submit" class="btn btn-dark" name="del" value="X">
        
            <input type="submit" name="subThisNews" value="editer" class="btn btn-outline-secondary"/>

          </div>
        </td>
      </tr>
    </form>
    <?php } ?>
  </tbody>
</table>

