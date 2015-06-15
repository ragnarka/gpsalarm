<div class="col-xs-12 col-md-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>Alarmer totalt</strong>
			<!--<div class="dropdown pull-right">
				<a id="dLabel" data-target="#" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
					<li><a href="#">Innstillinger</a></li>
					<li class="divider"></li>
					<?php if ($s->isAutheticated()) : ?>
					<li><a href="?action=logout">Logg ut</a></li>
					<?php else : ?>
					<li><a href="?action=login">Logg inn</a></li>
					<?php endif; ?>
				</ul>
			</div>-->
		</div>
		<div class="panel-body">
			<?php
				$filter = '';
				if (isset($_GET['f'])) {
					$startDate 	= (isset($_GET['sd'])) ? $_GET['sd'] : '';
					$endDate 	= (isset($_GET['ed'])) ? $_GET['ed'] : '';

					if (!$startDate == '' && !$endDate == '')
					{
						$filter = "WHERE datehour between '" . $startDate . "' and '" . $endDate . "'";
					}
				}

				$db->query("SELECT SUM(AlarmCountLow)+SUM(AlarmCountMedium)+SUM(AlarmCountHigh)+SUM(AlarmCountCritical) as NumAlarms FROM almData " . $filter);	
				$row = $db->fetch();
				echo '<h1>' . $row['NumAlarms'] . '</h1>';
				$db->freeStmt();
			?>
		</div>
	</div>
</div>