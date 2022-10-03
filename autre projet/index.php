<!DOCTYPE html>
<?php include ('nav.php');?>
	<h3>Saith Seren Centre</h3>
		<div class = "Prez">
			<p class = "prezeng">
			'Saith' is a centre for anyone who is proud to be, or interested in Welsh, to socialize and celebrate our culture. It provides a venue for Welsh language activities such as gigs, and sporting events on television with Welsh commentary on S4C. Clwb Clebran, every Thursday evening, gives Welsh language learners the opportunity to practice in an informal atmosphere outside the classroom. There are also many non-Welsh language activities e.g. darts, live bands on a Saturday night, but even on those nights, the Welsh spirit and culture is evident.
			</p>


			<p class = "prezgal"> 
			Mae ‘Saith’ yn ganolfan i unrhyw sy’n ymfalchïo, neu â diddordeb mewn Cymreictod, i gymdeithasu a dathlu ein diwylliant. Mae darparu lleoliad ar gyfer gweithgareddau Cymraeg fel gigiau,a dangos chwaraeon gyda sylwebaeth Cymraeg ar S4C. Mae Clwb Clebran pob nos Iau, yn rhoi cyfle i ddysgwyr yr iaith i ddod i ymarfer mewn awyrgylch anffurfiol y tu allan o’r dosbarth. Mae llawer o weithgareddau nad ydynt drwy’r Gymraeg yn Saith Seren hefyd, e.e. dartiau, bandiau byw nos Sadwrn, ond hyd yn oed ar y nosweithiau hynny, mae’r ysbryd a diwylliant Cymreig yn amlwg.	
			</p>	
		</div>
		<div class = "history">
			<fig>
				<img src = "https://media-cdn.tripadvisor.com/media/photo-s/06/b3/1a/5f/saith-seren.jpg" class = "image"/>
			</fig>

			<div class = "historytext">
				<p class = "historyeng"> 
				Saith Seren, Wrexham's Welsh Centre, opened in 2012, following the National Eisteddfod's visit to Wrexham in Summer 2011. The 'Seven Stars' pub had been vacant for 18 months, and local Councillor Marc Jones came up with the idea of re-open it as a Welsh Centre in order to build on the increased interest and pride in the language as a result of the Eisteddfod. He set up a Community Co-operative Company with a Management Board and shareholders. He persuaded Clwyd Alyn Housing Association to buy and renovate the listed building, which was then rented by the co-operative. 'Saith Seren' opened at the end of January 2012.
				</p>	

				<p class = "historygal">			
				Agorwyd Canolfan Gymraeg Wrecsam, Saith Seren, yn 2012, yn dilyn ymweliad yr Eisteddfod Genedlaethol i Wrecsam yn Haf 2011. Roedd tafarn y ‘Seven Stars’ wedi sefyll yn wag ers 18 mis, a chafodd Cyngorydd lleol, Marc Jones, y syniad o’i ail agor fel Canolfan Gymraeg er mwyn adeiladu ar y cynydd mewn diddordeb a balchder tuag at yr iaith yn sgil yr Eisteddfod.  Aeth ati i sefydlu Cwmni Cydweithredol Cymunedol gyda Bwrdd Rheoli a chyfrandalwyr. Perswadiodd Cymdeithas Tai Clwyd Alyn i brynu ac adnewyddu’r adeilad cofrestredig, gyda’r cwmni cydweithredol yn ei rhentu ganddyn nhw. Agorwyd ‘Saith Seren’ ar ddiwedd mis Ionawr 2012.
				</p>
			</div>
		</div>
		<br>
		<h3>News</h3>

    <?php
      session_start();
      include('contentdisplayer.php');
      $categ = "home"; //put a name for a content category here
      $obj = new simpleCMS();
      $obj->connect();

      if (isset($_POST["add"]))
      {$obj->write($_POST, $categ);}
      if (isset($_POST["update"])) 
      {$obj->update($_POST, $_POST["contentid"]);}
      
      if (isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) {
        echo $obj->display_admin($categ);
      } 
      else {
        echo $obj->display_public($categ);
      }
    ?>
	</div>
	<?php include ('footer.html');?>
	</body>

</html>