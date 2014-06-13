<h5 style="display:inline;margin-left:10px;">Lien à créer <span style="color:#A5260A">(Glissez ici les éléments)</span></h5>

<div id="fieldChooser" tabIndex="1">
	<div id="lienPers">
        <div id="sourceFields"><h3 style="display:inline;"><span style="color:#A5260A">Personne</span></h3>';
           foreach ($personnes as $pers) {
				$code.="<div>".$pers['CLT-Nom']." ".$pers['CLT-Prénom']."<input type='hidden' name='pers' value='".$pers['CLT-NumID']."'/></div>";
			}
		$code.='
        </div>
    </div>
    <div id="lienType">
        <div id="sourceFields"><h3 style="display:inline;"><span style="color:#A5260A">Type</span></h3>';
           foreach ($type_relation as $type) {
				$code.="<div>".$type['REL-Nom']."<input type='hidden' name='type' value='".$type['REL-Num']."'/></div>";
			}
		$code.='
        </div>
    </div>
    	<div id="lien">
        	<form method="post" action="index.php?action=addClientRelationel" id="formLien">
            	<div id="destinationFields">
            	</div>
	            <input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
	        </form>
        </div>
</div>