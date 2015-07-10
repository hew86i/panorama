<?php

	global $Dic;

	function dic($key){
		extract($GLOBALS, EXTR_REFS);
		print $Dic[$key][$cLang];
	};
	
	function dic_($key){
		extract($GLOBALS, EXTR_REFS);
		return $Dic[$key][$cLang];
	};
	
	function addLang($key, $mk, $en, $fr){
		extract($GLOBALS, EXTR_REFS);
		$Dic[$key][]=3;
		$Dic[$key]["mk"]=$mk;
		$Dic[$key]["en"]=$en;
		$Dic[$key]["fr"]=$fr;		
	};

		addLang("Login.Title", "Направи повеќе со помалку", "Do more with less", "Faire plus avec moins");
        addLang("Login.Description", "Управување со вашите мобилни добра", "Managing your mobile assets", "Gérer vos actifs mobiles");
		addLang("Login.Username", "Корисничко име", "Username", "Nom d`utilisateur");
		addLang("Login.Password", "Лозинка", "Password", "Mot de passe");
		addLang("Login.Button", "Најава", "Login", "Aller");
		addLang("Login.Legal", "Правна напомена", "Legal notice", "Mentions légales");
		addLang("Login.Privacy", "Полиса на приватност", "Privacy policy", "Politique de confidentialité");
		addLang("Login.Help", "Помош", "Help", "Aide");
		addLang("Login.Support", "Поддршка", "Support","Soutien");
		addLang("Login.WrongPassword", "Погрешно корисничко име или лозинка", "Wrong username or password","Mauvais nom d`utilisateur ou mot de passe");
		addLang("Login.ErrorMessage", "Грешка", "Error message","Message d`erreur");
        addLang("Login.Panorama", "Панорама", "Panorama", "Panorama");
        addLang("Login.PanoramaGPS", "Панорама ГПС", "Panorama GPS", "Panorama GPS");
        addLang("Login.keepLogged", "Задржи ме најавен 14 дена", "Keep me logged in 14 days", "Rester connecté 14 jours");
        addLang("Login.PermMenu", "Немате дозвола за тоа мени !!!", "You do not have permissions for that menu !!!", "Vous ne disposez pas des autorisations pour ce menu!!!");
		
		addLang("Main.LiveTitle", "Следење во живо", "Live tracking","Suivi en direct");
		addLang("Main.ReportsTitle", "Извештаи", "Reports","Rapports");
		addLang("Main.SettingsTitle", "Подесувања", "Settings","Réglages");
		addLang("Main.HelpTitle", "Помош", "Help","Aide");
		addLang("Main.Logout", "Одјави се", "Logout","Déconnexion");
		addLang("Main.Live", "Следење во живо на вашите возила", "Live Tracking your vehicles","Suivi en direct de vos véhicules");
		addLang("Main.Reports", "Анализи и извештаи на вашите возила", "Analyses and reports of your vehicles","Analyses et rapports de vos véhicules");
        addLang("Main.Settings", "Системски подесувања на апликацијата", "System settings application", "Différents paramètres de l'application du système");
		addLang("Main.Help", "Помош во апликацијата", "Help in the application","Aide de l'application");
		
		addLang("Reports.Summary", "Сумарни извештаи", "Summary reports","Les rapports de synthèse");
		addLang("Reports.Overview", "Преглед", "Overview","Aperçu");
        addLang("Reports.PominatoRastojanie", "Поминато растојание", "Spent distance", "Passez à distance");
        addLang("Reports.PominatoRastojanie1", "Растојание", "Distance", "Distance");
		addLang("Reports.Aktivnost", "Активност", "Activity","Activité");
		addLang("Reports.MaxSpeed", "Максимални брзини", "Max speed","Vitesse max");
		addLang("Reports.Speed", "Брзина", "Speed","Vitesse");
		
		addLang("Reports.AvgSpeed", "Просечни брзини", "Average speed", "Vitesse moyenne");
		addLang("Reports.From", "Од", "From", "De");
        addLang("Reports.To", "До", "Tо", "à");

        addLang("Reports.NoTours", "Број на тури", "Number of tours", "Nombre de visites");
        addLang("Reports.DistanceTour", "Вкупно поминато растојание по тури", "Total spent distance per tours", "La distance totale dépensée par visites");
        addLang("Reports.DistanceTour1", "Вкупно поминато<br>растојание по тури", "Total spent<br>distance per tours", "La distance<br>totale dépensée par visites");
        addLang("Reports.TotalCost", "Вкупен промет", "Total cost", "Coût total");
        addLang("Reports.AvgDuration", "Просечно времетраење по тура", "Average duration per tour", "La durée moyenne par visite");
        addLang("Reports.AvgNo", "Просечен број на", "Average number of", "Nombre moyen de");
        addLang("Reports.PerTour", "по тура", " per tour", "par visite");
        addLang("Reports.PriceSpent", "Цена на изминат", "Price of spent", "Prix ​​du passé");
        addLang("Reports.AvgPrice", "Просечна цена по тура", "Average price per tour", "Prix ​​moyen par visite");
		addLang("Reports.Choose", "Избери", "Choose", "Choisissez");
		addLang("Reports.Cancel", "Откажи", "Cancel", "Annuler");
		addLang("Reports.ViewOnMap", "Поглед на мапа", "View on map", "Voir sur la carte");
		addLang("Reports.Minutes", "Минути", "Minutes", "Minutes");
		addLang("Reports.ActivityOn", "Возење", "Driving", "Activité");
        addLang("Reports.ActivityOff", "Стоење", "Idle", "Ralenti");
		addLang("Reports.ActiveV", "Топ 5 активни возила", "Top 5 active vehicles", "Top 5 des véhicules actifs");
		addLang("Reports.PassiveV", "Топ 5 пасивни возила", "Top 5 idling vehicles", "Top 5 des véhicules passifs");
        addLang("Reports.IdlingReport", "Извештај за стоење во место", "Idling report", "Rapport de standing en place");
		
		addLang("Reports.PassiveV", "Топ 5 пасивни возила", "Top 5 passive vehicles", "Top 5 des véhicules passifs");
		
        addLang("Reports.Total1", "Вкупно поминато растојание", "Total spent distance", "Total des dépenses à distance");
        addLang("Reports.Total1_", "Вкупно поминато<br>растојание", "Total spent distance", "Total des dépenses à distance");
        addLang("Reports.TotalDist", "Вкупно растојание", "Total distance", "Distance totale");
        addLang("Reports.PrivacyPolice", "Полиса на приватност", "Privacy police", "Politique de confidentialité");
		addLang("Reports.Total2", "Вкупно работење со запален мотор", "Total time duration with engine on", "Durée totale avec moteur sur");
		addLang("Reports.Total3", "Вкупно работење со запален мотор во место", "Total time duration with engine on in place", "Durée totale avec moteur en place");
		addLang("Reports.Total4", "Вкупно работење со запален мотор во движење", "Total time duration with engine on in motion", "Durée totale avec moteur en marche");
		addLang("Reports.Total5", "Вкупно работење со исклучен мотор", "Total time duration with engine off", "Durée totale avec moteur hors");

        addLang("Reports.TotalIgnOff", "Вкупно работење со исклучен мотор", "Total ignition OFF", "D'allumage totale OFF");

        addLang("Reports.Total2_", "Вкупно работење со запален мотор", "Total duration with engine on", "Durée totale avec moteur sur");
        addLang("Reports.Total3_", "Вкупно работење со запален мотор во место", "Total duration with idling", "Durée totale avec la marche au ralenti");
        addLang("Reports.Total4_", "Вкупно работење со запален мотор во движење", "Total duration with driving", "Durée totale avec moteur en marche");
        addLang("Reports.Total5_", "Вкупно работење со исклучен мотор", "Total duration with engine off", "Durée totale avec moteur hors");

        addLang("Reports.Total6", "Максимална брзина", "Maximum speed", "Vitesse maximale");
        addLang("Reports.TotalVehicles", "Вкупен број на возила", "Total number of vehicles", "Nombre total de véhicules");
		
        addLang("Reports.Top10VisitPOI", "Топ 10 најпосетувани точки од интерес", "Top 10 most visited points of interest", "Top 10 des plus visités des points d`intérêt");
		addLang("Reports.Top10VisitGF", "Топ 10 најпосетувани зони", "Top 10 most visited geofences", "Top 10 les plus visités geofences");
		addLang("Reports.Rbr", "Р. бр.", "No.", "Aucun");
        addLang("Reports.POI", "Точка од интерес", "Point of interest", "Point d`intérêt");
		addLang("Reports.NoVisit", "Број на посети", "Number of visits", "Nombre de visites");
		addLang("Reports.Registration", "Регистaрски број", "Registration number", "Numéro d'enregistrement");
        addLang("Reports.NoData1", "Нема податоци", "No data", "Pas de données");
		
		addLang("Reports.IgnitionON", "Уклучен мотор", "Ignition ON", "Numéro d`enregistrement");
        addLang("Reports.IgnitionOff", "Исклучен мотор", "Ignition OFF", "Numéro d`enregistrement");
		addLang("Reports.StoenjeVoMesto", "Стоење во место со уклучен мотор", "Standing in place with engine on", "Permanent mis en place avec le moteur");
		addLang("Reports.Dvizenje", "Движење", "Movement", "Mouvement");
		addLang("Reports.Vreme", "Време", "Time", "Temps");
        addLang("Reports.RecTime", "Време на пристигнување", "Time of receipt", "L'heure de réception");
		addLang("Reports.Datum", "Датум", "Date", "date de");
        addLang("Reports.PominatoVreme", "Времетраење", "Time duration", "durée");
        addLang("Reports.PominatoVreme1", "Времетраење", "Duration", "durée");
		addLang("Reports.StatusMotor", "Статус на моторот", "Ignition status", "le statut d'allumage");
        addLang("Reports.SummData", "Сумарни податоци", "Summary data", "Les données sommaires");

		addLang("Reports.Loading", "Вчитување", "Loading", "Chargement");
        addLang("Reports.POIs", "Точки од интерес", "Points of interest", "Points d`intérêt");
        addLang("Reports.ShortReport", "Краток извештај", "Short report", "Bref rapport");
		addLang("Reports.VehcileReport", "Извештаи за едно возило", "Reports for one vehicle", "Rapports d'un véhicule");
		
		addLang("Reports.ON", "Уклучен", "ON", "Tournée");
		addLang("Reports.OFF", "Исклучен", "OFF", "OFF");
		
		addLang("Reports.sDate", "Почетен датум", "Start date", "Date de début");
		addLang("Reports.eDate", "Краен датум", "End date", "Date de fin");
		addLang("Reports.Vehicle", "Возило", "Vehicle", "Véhicule");
		
        addLang("Reports.sTime", "Почетно време", "Start time", "l'heure de début");
        addLang("Reports.eTime", "Крајно време", "End time", "Grand temps de");
        addLang("Reports.VisitedPOI", "Посетени точки од интерес", "Visited points of interest", "Visité les points d'intérêt");
		
        addLang("Reports.VisitedPOIByNumber", "Топ 5 најпосетувани точки од интерес по број на посети", "Top 5 visited points of interest by number of visits", "Top 5 visité les points d`intérêt par le nombre de visites");
        addLang("Reports.VisitedPOIByDuration", "Топ 5 најпосетувани точки од интерес по потрошено време", "Top 5 visited points of interest by duration", "Top 5 visité les points d`intérêt par la durée");
		
		addLang("Reports.Detail", "Детален извештај", "Detail report", "Rapport détaillé");
		
		
		addLang("Reports.PastDistance", "Поминато растојание", "Past distance","Passé à distance");
		addLang("Reports.Summary1", "Сумирано", "Summary","Résumé");
		addLang("Reports.More", "Повеќе", "More","Plus");
		
		addLang("Reports.Taxi", "Извештаи за такси компании", "Taxi reports","Rapports de taxi");
		addLang("Reports.TaxiTour", "Извештај за тури", "Report tours","Signaler visites");
        addLang("Reports.Step", "Чекор", "Step", "étape");

        addLang("Reports.ComRes", "Резултати од споредбата", "Results of the comparison", "Résultats de la comparaison");
        addLang("Reports.Here", "тука", "here", "ici");
        addLang("Reports.Step1", "Изберете временски опсег на кој ќе се однесува споредбата", "Select a datetime range that will apply to the comparison", "Sélectionnez un intervalle de temps qui s'appliquera à la comparaison");
        addLang("Reports.ComVeh", "Изберете возилa кои сакате да ги споредувате", "Choose vehicles you want to compare", "Choisissez les véhicules que vous souhaitez comparer");
        addLang("Reports.Step2", "Изберете категории по кои сакате да ги споредувате возилата", "Select categories on which you want to compare the vehicles", "Choisissez les catégories sur lesquelles vous souhaitez comparer les véhicules");


        addLang("Reports.ComText", "Доколку сакате да направите споредба меѓу некои од вашите возила, Ве молиме изберете:<br />▪ <b>временски опсег</b> на кој ќе се однесува споредбата;<br />▪ <b>возила</b> кои сакате да ги споредувате;<br />▪ <b>категории</b> по кои ќе се споредуваат избраните возила.<br /><br />За споредба кликнете", "If you want to make a comparison between some of your vehicles, please select: <br /> ▪ <b> datetime range </ b> that will apply to the comparison; <br /> ▪ <b> vehicles </ b> that you want to compare; <br /> ▪ <b> categories </ b> on which the selected vehicles will be compared. <br /> <br /> For new comparison click", "Si vous voulez faire une comparaison entre certains de vos véhicules, s'il vous plaît choisir: <br /> ▪ <b> gamme datetime </ b> qui portera sur la comparaison; <br /> ▪ Les <b> véhicules </ b> que vous voulez comparer; <br /> ▪ <b> catégories </ b> sur lequel les véhicules sélectionnés seront comparés. <br /> <br /> Pour clic nouvelle comparaison");
        addLang("Reports.GeofenceEmail", "извештајот за зоните", "the Geofence report", "le rapport Geofence");
        addLang("Reports.TaxiEmail", "такси извештајот", "the Taxi report", "le rapport de taxi");
        addLang("Reports.PoiEmail", "извештајот за посетени точки од инетерес", "the Visited POi report", "souligne le rapport visités par ineteres");
        addLang("Reports.ShortEmail", "краткиот извештај", "the Short report", "le rapport abrégé");
        addLang("Reports.OverviewEmail", "извештајот за преглед", "the Overview report", "Rapport d'examen");
        addLang("Reports.DashboardEmail", "dashboard извештајот", "the Dashboard report", "le rapport de tableau de bord");
        addLang("Reports.FleetEmail", "извештајот за флота на возила", "the Fleet report", "le rapport de la flotte");
        addLang("Reports.DistEmail", "извештајот за поминато растојание", "the Distance travelled report", "rapport est consacrée à une distance");
        addLang("Reports.ActEmail", "извештајот за активност", "the Activity report", "le rapport d'activité");
        addLang("Reports.SpeedEmail", "извештајот за максимални брзини", "the Max speed report", "le rapport de vitesse max");
        addLang("Reports.ExcEmail", "извештајот за надминување на дозволената брзина", "the Speed excess report", "rapport à surmonter la limite de vitesse");
        addLang("Reports.IdleEmail", "извештајот за стоење во место", "the Idling report", "le rapport marche au ralenti");
        addLang("Reports.SummTaxiEmail", "сумарниот такси извештај", "the summary taxi report", "le rapport de taxi résumé");
        addLang("Reports.SummTaxi", "Сумарен такси извештај", "Summary taxi report", "Rapport de taxi Résumé");
        addLang("Reports.email1", "Почитувани,<br />корисникот", "Dear Sir or Madam,<br />the user", "Cher Monsieur ou Madame, <br /> lutilisateur");
        addLang("Reports.email2", "во продолжение Ви испраќа линк на кој може да го погледнете", "sends you a link where you can see", "vous envoie un lien où vous pouvez voir");
        addLang("Reports.email3", "за", "for", "pour");
        addLang("Reports.email4", "за периодот од", "for the period from", "pour la période allant");
        addLang("Reports.email5", "до", "to", "à");
        addLang("Reports.PanoramaGPS", "Панорама ГПС", "Panorama GPS", "Panorama GPS");
        addLang("Reports.VehicleReports", "Извештаи за возилата", "Vehicle reports", "Rapports des véhicules");
        addLang("Reports.Reconstruction", "Реконструкција", "Reconstruction", "Reconstruction");
        addLang("Reports.TaxiReport", "Такси извештај", "Taxi report", "Rapport taxi");
        addLang("Reports.GeoFenceReport", "Извештај за зони", "GeoFence report", "Rapport GeoFence");
        addLang("Reports.Analysis", "Анализи", "Analysis", "Analyse");
        addLang("Reports.StartDatetime", "Почетен датум и време", "Start datetime", "Début datetime");
        addLang("Reports.EndDatetime", "Краен датум и време", "End datetime", "Début datetime");
        addLang("Reports.InTime", "Влезно време", "In time", "Dans le temps");
        addLang("Reports.OutTime", "Излезно време", "Out time", "Sur le temps");
        addLang("Reports.Yesterday", "Вчера", "Yesterday", "Hier");
        addLang("Reports.Today", "Денес", "Today", "Aujourd'hui");
        addLang("Reports.CurrentWeek", "Теков.недела", "Current week", "Semaine en cours");
        addLang("Reports.LastWeek", "Послед.недела", "Last week", "La semaine dernière");
        addLang("Reports.Last10Days", "Послед.10 дена", "Last 10 days", "10 derniers jours");
        addLang("Reports.CurrentMonth", "Теков.месец", "Current month", "Du mois en cours");
        addLang("Reports.LastMonth", "Послед.месец", "Last month", "Mois dernier");
        addLang("Reports.Custom", "Прилагодено", "Custom", "Coutume");
        addLang("Reports.Show", "Прикажи", "Show", "Montrer");
        addLang("Reports.Dashboard", "Dashboard", "Dashboard", "Tableau de bord");
        addLang("Reports.DashboardExcel", "D A S H B O A R D", "D A S H B O A R D", "tableau de bord");
        addLang("Reports.User", "Корисник", "User", "Utilisateur");
        addLang("Reports.Company", "Компанија", "Company", "Entreprise");
        addLang("Reports.CreationDate", "Датум на креирање", "Creation date", "Date de création");
        addLang("Reports.DateRange", "Опсег", "Date range", "Date de gamme");
        addLang("Reports.DateTimeRange", "Временски опсег", "Date time range", "Intervalle de temps Date de");
        addLang("Reports.AllVehicles", "Сите возила", "All vehicles", "Tous les véhicules");
        addLang("Reports.DemoCompany", "Демо компанија", "Demo company", "Entreprise démo");
        addLang("Reports.FleetReport", "Извештај за флотата на возила", "Fleet report", "Flotte rapport");
        addLang("Reports.DistanceTravelled", "Поминато растојание", "Distance travelled", "Distance parcourue");
        addLang("Reports.Idling", "Стоење", "Idling", "La marche au ralenti");
        addLang("Reports.Parked", "Паркирано", "Parked", "Stationné");
        addLang("Reports.TotalParked", "Вкупно време на паркирање", "Total parked", "Total des stationné");
        addLang("Reports.ShutDown", "Затвори", "Shut down", "Arrêter");
        addLang("Reports.SpeedLimitExcess", "Надминување на дозвол. брзина", "Speed limit excess", "Excès de vitesse limite");
        addLang("Reports.SpeedLimitExcess1", "Надминување на дозволената брзина", "Speed limit excess", "Excès de vitesse limite");
        addLang("Reports.SpeedExcess", "Надминување на брзина", "Speed excess", "Excès de vitesse");
        addLang("Reports.Over", "Над", "Over", "Sur");
        addLang("Reports.NoData", "Нема податоци за бараниот период !!!", "No data for the requested period !!!", "Pas de données pour la période demandée!!!");
        addLang("Reports.Top30PoiVisits", "Први 30 точки од интерес според посети", "TOP 30 POI by visits", "TOP 30 par POI visites");
        addLang("Reports.Top30PoiDuration", "Први 30 точки од интерес според времетраење", "TOP 30 POI by duration", "TOP 30 POI par la durée");
        addLang("Reports.Top30GeoFenceVisits", "Први 30 зони според посети", "TOP 30 GeoFence by visits", "TOP GeoFence 30 par des visites");
        addLang("Reports.Top20GeoFenceVisits", "Први 20 најпосетени зони", "TOP 20 most visited GeoFences", "TOP 20 les plus visités Geofences");
        addLang("Reports.Top30GeoFenceDuration", "Први 30 зони според времетраење", "TOP 30 GeoFence by duration", "TOP 30 GeoFence par la durée");
        addLang("Reports.GeoFence", "Зона", "GeoFence", "GeoFence");
        addLang("Reports.Permission", "Немате дозвола за овој извештај !!!", "You do not have permissions for this report !!!", "Vous ne disposez pas des autorisations pour ce rapport!!!");
        addLang("Reports.ReportNotLoaded", "Извештајот не може да се вчита !!!", "The report could not be loaded !!!", "Le rapport n'a pas pu être chargé!");
        addLang("Reports.FleetReportExcel", "И З В Е Ш Т А Ј&nbsp; &nbsp; &nbsp;З А&nbsp; &nbsp; &nbsp;Ф Л О Т А Т А&nbsp; &nbsp; &nbsp;Н А&nbsp; &nbsp; &nbsp;В О З И Л А", "F L E E T&nbsp; &nbsp; &nbsp;R E P O R T", "F L E E T&nbsp; &nbsp; &nbsp;R A P O R T");
        addLang("Reports.SpeedExcessOver", "Надминување на максималната дозволена брзина", "Speed excees over", "Excees vitesse plus");
        addLang("Reports.Description", "Опис", "Description", "Description");
        addLang("Reports.Value", "Вредност", "Value", "Valeur");
        addLang("Reports.Visits", "Посети", "Visits", "Visites");
        addLang("Reports.OverviewExcel", "П Р Е Г Л Е Д", "O V E R V I E W", "UN V E R V I E W");
        addLang("Reports.Top20VisitedPoi", "Први 20 најпосетени точки од интерес", "Top 20 most visited points of interest", "Top 20 les plus visités points d'intérêt");
        addLang("Reports.EngineOn", "Вклучен мотор", "Engine ON", "Moteur ON");
        addLang("Reports.EngineOff", "Исклучен мотор", "Engine OFF", "Moteur OFF");
        addLang("Reports.NoStops", "Број на застанувања", "Number of stops", "Le nombre d'arrêts");
        addLang("Reports.TotalParked", "Вкупно време на паркирање", "Total time parked", "Le temps total garé");
        addLang("Reports.StartPosition", "Почетна позиција", "Start position", "Position de départ");
        addLang("Reports.EndPosition", "Крајна позиција", "End position", "Fin de course");
        addLang("Reports.Location", "Локација", "Location", "Emplacement");
        addLang("Reports.DateTime", "Датум и време ", "Datetime", "Datetime");
        addLang("Reports.TimeParked", "Време на паркирање ", "Time parked", "Temps de stationnement");
        addLang("Reports.Time", "Време", "Time", "Temps");
        addLang("Reports.ShortExcel", "К Р А Т О К&nbsp; &nbsp; &nbsp;И З В Е Ш Т А Ј ", "S H O R T&nbsp; &nbsp; &nbsp;R E P O R T ", "S H O R T&nbsp; &nbsp; &nbsp;R E P O R T");
        addLang("Reports.NameGroup", "Име на група", "Name of group", "Nom du groupe");
        addLang("Reports.ChooseIcon", "Избери икона", "Choose icon", "Choisissez l'icône");
        addLang("Reports.Color", "Боја", "Color", "Couleur");
        addLang("Reports.DeletePoi?", "Дали сте сигурни дека сакате да ја избришете оваа точка од интерес?", "Are you sure you want to delete this point of interest?", "Etes-vous sûr de vouloir supprimer ce point d'intérêt?");
        addLang("Reports.DeleteGeoFence?", "Дали сте сигурни дека сакате да ја избришете оваа зона?", "Are you sure to want to delete this GeoFence?", "Etes-vous sûr de vouloir supprimer ce GeoFence?");
        addLang("Reports.Latitude", "Географска ширина", "Latitude", "Latitude");
        addLang("Reports.Longitude", "Географска должина", "Longitude", "Longitude");
        addLang("Reports.Address", "Адреса", "Address", "Adresse");
        addLang("Reports.NamePoi", "Име на точка од интерес", "Name of POI", "Nom du POI");
        addLang("Reports.AddInfo", "Дополнителни информации", "Additional info", "Informations complémentaires");
        addLang("Reports.AvailableFor", "Достапни за", "Available for", "Disponible pour");
        addLang("Reports.OnlyMe", "Само мене", "Only me", "Seulement moi");
        addLang("Reports.AllUsers", "Сите корисници", "All Users", "Tous les utilisateurs");
        addLang("Reports.CannotChange", "Без промена", "Can't change", "Impossible de changer");
        addLang("Reports.Group", "Група", "Group", "Groupe");
        addLang("Reports.SelectGroup", "Ве молиме изберете група", "Please select group", "S'il vous plaît sélectionner le groupe");
        addLang("Reports.GeoFenceName", "Име на зона", "GeoFence name", "Nom GeoFence");
        addLang("Reports.AllowedInGeoFence", "Дозволени во оваа зона", "Allowed in this GeoFence", "Admis dans ce GeoFence");
        addLang("Reports.AlertEnter", "Испрати алерт на влегување", "Send alert when entering", "Envoyer alerter lors de la saisie");
        addLang("Reports.AlertExit", "Испрати алерт на излегување", "Send alert when exiting", "Envoyer alerter lorsque vous quittez");
        addLang("Reports.AlertAllowEnter", "Испрати алерт кога влегува било кое од дозволените возила", "Send alert when any of allowed vehicles entering", "Envoyer une alerte lorsque des véhicules autorisés d'entrer");
        addLang("Reports.AlertAllowExit", "Испрати алерт кога излегува било кое од дозволените возила", "Send alert when any of allowed vehicles exiting", "Envoyer une alerte lorsque des véhicules autorisés sortie");
        addLang("Reports.AlertNotAllowEnter", "Испрати алерт кога влегува било кое од недозволените возила", "Send alert when any of not allowed vehicles entering", "Envoyer alerter quand un des véhicules non autorisés d'entrer");
        addLang("Reports.AlertNotAllowExit", "Испрати алерт кога излегува било кое од недозволените возила", "Send alert when any of not allowed vehicles exiting", "Envoyer alerter quand un des véhicules ne sont pas admis sortant");
        addLang("Reports.AlertEmail", "Испрати алерт на овие е-маилови", "Send alert on these emails", "Envoyer alerter sur ces e-mails");
        addLang("Reports.AlertPhone", "Испрати алерт на овие телефонски броеви", "Send alert on these phone numbers", "Envoyer alerter sur ces numéros de téléphone");
        addLang("Reports.Example", "Пример", "Example", "Exemple");
        addLang("Reports.MacExample", "пример само за Македонија", "only for Macedonia example", "que, par exemple Macédoine");
        addLang("Reports.Detail1", "Детален", "Detail", "Détail");
        addLang("Reports.Summary1", "Сумарен", "Summary", "Résumé");
        addLang("Reports.SpeedChart", "График  на брзина", "Speed chart", "Tableau de vitesse");
        addLang("Reports.TaxiChart", "Такси график", "Taxi chart", "Tableau taxi");
        addLang("Reports.TaximeterOff", "Исклучен таксиметар", "Taximeter OFF", "Taximètre OFF");
        addLang("Reports.Passengers0", "Патници 0", "Passengers 0", "Passagers 0");
        addLang("Reports.TimeDifference", "Разлика во време", "Time difference", "Décalage horaire");
        addLang("Reports.Distance", "Растојание", "Distance", "Distance");
        addLang("Reports.Price", "Цена", "Price", "​​Prix");
        addLang("Reports.Total", "Вкупно", "Total", "Total");
        addLang("Reports.Currency", "ден", "den", "den");
        addLang("Reports.TaxiReportExcel", "Т А К С И&nbsp;&nbsp;&nbsp;И З В Е Ш Т А Ј", "T A X I&nbsp;&nbsp;&nbsp;R E P O R T", "T A X I&nbsp;&nbsp;&nbsp;R A P O R T");
        addLang("Reports.SummTaxiExcel", "С У М А Р Е Н&nbsp;&nbsp;&nbsp;Т А К С И&nbsp;&nbsp;&nbsp;И З В Е Ш Т А Ј", "S U M M A R Y&nbsp;&nbsp;&nbsp;T A X I&nbsp;&nbsp;&nbsp;R E P O R T", "R A P P O R T&nbsp;&nbsp;&nbsp;D E&nbsp;&nbsp;&nbsp;T A X I&nbsp;&nbsp;&nbsp;R É S U M É");
        addLang("Reports.Duration", "Времетраење", "Duration", "Durée");
        addLang("Reports.Allowed", "Дозволено", "Allowed", "Permis");
        addLang("Reports.Yes", "Да", "Yes", "Oui");
        addLang("Reports.No", "Не", "No", "Non");
        addLang("Reports.GeoFenceExcel", "И З В Е Ш Т А Ј&nbsp;&nbsp;&nbsp;З А&nbsp;&nbsp;&nbsp;З О Н И", "G E O F E N C E&nbsp;&nbsp;&nbsp;R E P O R T", "G E O F E N C E&nbsp;&nbsp;&nbsp;R A P O R T");
        addLang("Reports.IdlingExcel", "И З В Е Ш Т А Ј&nbsp;&nbsp;&nbsp;З А&nbsp;&nbsp;&nbsp;С Т О Е Њ Е&nbsp;&nbsp;&nbsp;В О&nbsp;&nbsp;&nbsp;М Е С Т О", "I D L I N G&nbsp;&nbsp;&nbsp;R E P O R T", "R A P P O R T&nbsp;&nbsp;&nbsp;D E&nbsp;&nbsp;&nbsp;S T A N D I N G&nbsp;&nbsp;&nbsp;E N&nbsp;&nbsp;&nbsp;P L A C E");
        addLang("Reports.FleetTotal", "Вкупно на флотата", "Fleet total", "Totale de la flotte");
        addLang("Reports.FleetAverage", "Просек на флотата", "Fleet average", "Moyen de la flotte");
        addLang("Reports.VehicleAverage", "Просек на возило", "Vehicle average", "Véhicule en moyenne");
        addLang("Reports.Average", "Просек", "Average", "Moyenne");
        addLang("Reports.DistTravExcel", "П О М И Н А Т О&nbsp;&nbsp;&nbsp;&nbsp;Р А С Т О Ј А Н И Е", "D I S T A N C E&nbsp;&nbsp;&nbsp;&nbsp;T R A V E L L E D", "DISANCE&nbsp;&nbsp;&nbsp;&nbsp;PARCOURUE");
        addLang("Reports.Date", "Датум", "Date", "Date");
        addLang("Reports.EnOnPassOff", "Мотор OFF Патници ON", "Engine OFF Passengers ON", "Les passagers le moteur ON");
        addLang("Reports.LowSat", "Слаби сателити", "Low satellite", "Par satellite à faible");
        addLang("Reports.TaximeterOn", "Таксиметар ON", "Taximeter ON", "Taximètre ON");
        addLang("Reports.TaxiOffPassOn", "Таксиметар OFF Патници ON", "Taximeter OFF Passengers ON", "Taximètre les passagers dans");
        addLang("Reports.Engaged", "Ангажирано", "Occupied", "Occupé");
        addLang("Reports.Legend", "Легенда", "Legend", "Légende");
        addLang("Reports.ActivityExcel", "А К Т И В Н О С Т", "A C T I V I T Y", "ACTIVITE");
        addLang("Reports.MaximumSpeed", "Максимална брзина", "Maximum speed", "Vitesse maximale");
        addLang("Reports.MaxSpeedExcel", "М А К С И М А Л Н А&nbsp;&nbsp;&nbsp;&nbsp;Б Р З И Н А", "M A X&nbsp;&nbsp;&nbsp;&nbsp;S P E E D", "VITESSE&nbsp;&nbsp;&nbsp;&nbsp;MAX");
        addLang("Reports.Recurrence", "Повторување", "Recurrence", "Récurrence");
        addLang("Reports.SpeedOver", "Брзина над ", "Speed over ", "Vitesse sur le");
        addLang("Reports.SpeedLimitExcel", "Н А Д М И Н У В А Њ Е&nbsp;&nbsp;&nbsp;&nbsp;Н А&nbsp;&nbsp;&nbsp;&nbsp;Д О З В О Л Е Н А Т А&nbsp;&nbsp;&nbsp;&nbsp;Б Р З И Н А", "S P E E D&nbsp;&nbsp;&nbsp;&nbsp;L I M I T&nbsp;&nbsp;&nbsp;&nbsp;E X C E S S", "LIMITE&nbsp;&nbsp;&nbsp;&nbsp;DE&nbsp;&nbsp;&nbsp;&nbsp;VITESSE&nbsp;&nbsp;&nbsp;&nbsp;EXCESSIVE");
        addLang("Reports.GeoFenceRecord", "Зоната беше успешно снимена.", "GeoFence was successfully recorded.", "GeoFence a été enregistré avec succès.");
        addLang("Reports.GeoFenceModify", "Зоната беше успешно изменета.", "GeoFence was successfully modified.", "GeoFence a été correctement modifié.");
        addLang("Reports.Error", "Грешка !!!", "Error !!!", "Erreur!!!");
        addLang("Reports.ThePoi", "Точката од интерес ", "The point of interest ", "Le point d'intérêt");
        addLang("Reports.SucAdd", " беше успешно додадена.", " was successfully added.", "a été ajouté avec succès.");
        addLang("Reports.TheGroup", "Групата ", "The group ", "Le groupe");
        addLang("Reports.WrongPass", "Погрешна лозинка !!! ", "Wrong password !!!", "Mot de passe incorrect!!!");
        addLang("Reports.SucDel", "Зоната беше успешно избришана.", "GeoFence was successfully deleted.", "GeoFence a été supprimé avec succès.");
        addLang("Reports.SucDelPoi", "Точката од интерес беше успешно избришана.", "Point of interest was successfully deleted.", "Point d'intérêt a été supprimé avec succès.");
        addLang("Reports.SucSave", "Зоната беше успешно зачувана.", "GeoFence was successfully saved.", "GeoFence a été correctement enregistré.");
        addLang("Reports.SucUpd", " беше успешно ажурирана.", " was successfully updated.", "a été mis à jour.");
        addLang("Reports.SucSent", "Извештајот беше успешно испратен на вашиот е-маил", "The report was successfully sent to your e-mail.", "Le rapport a été envoyé avec succès à votre adresse e-mail.");
        addLang("Reports.CorrForm", "Внесете правилна форма на е-маилот", "Enter correct form of the e-mail", "Entrez une forme correcte de l'e-mail");
        addLang("Reports.EnterEmail", "Внесете го е-маилот:", "Enter the e-mail:", "Entrez l'adresse e-mail:");
        addLang("Reports.Reports", "Извештаи", "Reports", "Rapports");
        addLang("Reports.Report", "Извештај", "Report", "Rapport");
        addLang("Reports.AddSchedule", "Додади распоред", "Add schedule", "Ajouter planifier");
        addLang("Reports.SendReport", "Испрати го извештајот на е-маил", "Send the report to e-mail", "Envoyer le rapport à l'e-mail");
        addLang("Reports.Message", "Порака...", "Message...", "Message ...");
        addLang("Reports.Period", "Период", "Period", "Période");
        addLang("Reports.PeriodRec", "Период на пристигнување", "Period of receipt", "Période de réception");
        addLang("Reports.SchNote", "* За внес на повеќе е-маилови одделувајте со ;<br />Пример:n1@example.com;n2@example.com;", "* To enter multiple e-mails separate by ;<br /> Example: n1@example.com; n2@example.com;", "* Pour entrer plusieurs adresses e-mails séparés les e-mails par ;<br /> Exemple: n1@example.com; n2@example.com;");
        addLang("Reports.AllCategories", "Сите категории", "All categories", "Toutes les catégories");
        addLang("Reports.Daily", "Дневно", "Daily", "Quotidien");
        addLang("Reports.Weekly", "Неделно", "Weekly", "Semaine");
        addLang("Reports.Monthly", "Месечно", "Monthly", "Mensuel");
        addLang("Reports.Day", "Ден", "Day", "Jour");
        addLang("Reports.Monday", "Понеделник", "Monday", "Lundi");
        addLang("Reports.Tuesday", "Вторник", "Tuesday", "Mardi");
        addLang("Reports.Wednesday", "Среда", "Wednesday", "Mercredi");
        addLang("Reports.Thursday", "Четврок", "Thursday", "Jeudi");
        addLang("Reports.Friday", "Петок", "Friday", "Vendredi");
        addLang("Reports.Saturday", "Сабота", "Saturday", "Samedi");
        addLang("Reports.Sunday", "Недела", "Sunday", "Dimanche");
        addLang("Reports.Email", "Е-маил", "E-mail", "E-mail");
        addLang("Reports.SucUpdGeoFenceName", "Името на зоната беше успешно ажурирано.", "GeoFence name was successfully updated.", "Nom GeoFence a été correctement mis à jour.");
        addLang("Reports.DrawingAreas", "Цртање на зони", "Drawing areas", "Zones de dessin");
        addLang("Reports.VisitedPoiExcel", "П О С Е Т Е Н И&nbsp; &nbsp; &nbsp;Т О Ч К И&nbsp; &nbsp; &nbsp;ОД&nbsp; &nbsp; &nbsp;И Н Т Е Р Е С", "V I S I T E D&nbsp; &nbsp; &nbsp;P O I N T S&nbsp; &nbsp; &nbsp;OF&nbsp; &nbsp; &nbsp;I N T E R E S T", "POINTS&nbsp; &nbsp; &nbsp;D'INTÉRÊT&nbsp; &nbsp; &nbsp;VISITÉS");
		
        addLang("Reports.TotalIdle", "Вкупно стоење во место", "Total time idling", "Le temps total au ralenti");
        addLang("Reports.EnterCorrForm", "Внеси правилен формат на е-маилот!", "Enter correct form of the e-mail!", "Entrez une forme correcte de l'e-mail");

        addLang("Reports.Comparison", "Споредба", "Comparison", "Comparaison");
        addLang("Reports.Monday", "Понеделник", "Monday", "Lundi");
        addLang("Reports.Tuesday", "Вторник", "Tuesday", "Mardi");
        addLang("Reports.Wednesday", "Среда", "Wednesday", "Mercredi");
        addLang("Reports.Thursday", "Четврток", "Thursday", "Jeudi");
        addLang("Reports.Friday", "Петок", "Friday", "Vendredi");
        addLang("Reports.Saturday", "Сабота", "Saturday", "Samedi");
        addLang("Reports.Sunday", "Недела", "Sunday", "Dimanche");

        addLang("Reports.Red", "Црвена", "Red", "Rouge");
        addLang("Reports.Gray", "Сива", "Gray", "Pris");
        addLang("Reports.Green", "Зелена", "Green", "Vert");
        addLang("Reports.Yellow", "Жолта", "Yellow", "Jaune");

        addLang("Reports.AvgPriceTour", "Просечна цена по тура", "Average price per tour", "Prix ​​moyen par visite");
        addLang("Reports.AvgPriceTour1", "Просечна цена<br>по тура", "Average price<br>per tour", "Prix ​​moyen<br>par visite");
        addLang("Reports.AvgDurTour", "Просечно времетраење по тура", "Average duration per tour", "La durée moyenne par visite");
        addLang("Reports.AvgDurTour1", "Просечно времетраење<br>по тура", "Average duration<br>per tour", "La durée<br>moyenne par visite");
        addLang("Reports.AvgNoOf", "Просечен број на", "Average number of", "Nombre moyen de");
        addLang("Reports.PerTour", "по тура", "per tour", "par visite");
        addLang("Reports.PriceSpent", "Цена на потрошен/а", "Price of spent", "Prix ​​du passé");
        addLang("Reports.AddGroup", "Додади група", "Add group", "Ajouter un groupe");
        addLang("Reports.DeletePoi", "Избриши точка од интерес", "Delete POI", "Supprimer POI");
        addLang("Reports.DeleteGeoFence", "Избриши зона", "Delete GeoFence", "Supprimer GeoFence");

        addLang("Reports.ExportPDF", "Пренос во PDF", "Export to PDF", "Exporter au format PDF");
        addLang("Reports.ExportExcel", "Пренос во excel", "Export to excel", "Exporter vers Excel");
        addLang("Reports.AddScheduler", "Додади распоред", "Add scheduler", "Ajouter ordonnanceur");
        addLang("Reports.SendToMail", "Испрати на е-маил", "Send to e-mail", "Envoyer un e-mail");
        addLang("Reports.Taximeter", "Таксиметар", "Taximeter", "Taximètre");
        addLang("Reports.Passengers", "Патници", "Passengers", "Passagers");
        addLang("Reports.Last1", "Последен", "Last", "Dernier");
        addLang("Reports.LastMore", "Последни", "Last", "Dernier");

        addLang("Reports.Day_", "ден", "day", "jour");
        addLang("Reports.Days_", "дена", "days", "journées");

        addLang("Tracking.GeoFenceRecord", "Зоната е успешно снимена.", "GeoFence was successfully recorded.", "GeoFence a été enregistré avec succès.");
        addLang("Tracking.Color", "Боја", "Color", "Couleur");
        addLang("Tracking.Legend", "Легенда", "Legend", "Légende");
        addLang("Tracking.Message", "Порака...", "Message...", "Message ...");
        addLang("Tracking.GroupName", "Име на група", "Name of group", "Nom du groupe");
        addLang("Tracking.ChooseIcon", "Избери икона", "Choose icon", "Choisissez l'icône");
        addLang("Tracking.DeleteThisPoi?", "Дали сте сигурни дека сакате да ја избришете оваа точка од инетерес?", "Are you sure you want to delete this point of interest?", "Etes-vous sûr de vouloir supprimer ce point d'intérêt?");
        addLang("Tracking.DeleteThisGeoFence?", "Дали сте сигурни дека сакате да ја избришете оваа зона?", "Are you sure you want to delete this GeoFence?", "Etes-vous sûr de vouloir supprimer ce GeoFence?");
        addLang("Tracking.Latitude", "Географска ширина", "Latitude", "Latitude");
        addLang("Tracking.Longitude", "Географска должина", "Longitude", "Longitude");
        addLang("Tracking.Address", "Адреса", "Address", "Adresse");
        addLang("Tracking.NamePoi", "Име на точка од интерес", "Name of POI", "Nom du POI");
        addLang("Tracking.AddInfo", "Дополнителни информации", "Additional info", "Informations complémentaires");
        addLang("Tracking.AvailableFor", "Достапни за", "Available for", "Disponible pour");
        addLang("Tracking.OnlyMe", "Само мене", "Only me", "Seulement moi");
        addLang("Tracking.AllUsers", "Сите корисници", "All Users", "Tous les utilisateurs");
        addLang("Tracking.CannotChange", "Без промена", "Can't change", "Impossible de changer");
        addLang("Tracking.Group", "Група", "Group", "Groupe");
        addLang("Tracking.SelectGroup", "Ве молиме изберете група", "Please select group", "S'il vous plaît sélectionner le groupe");
        addLang("Tracking.Delete", "Избриши", "Delete", "Effacer");
        addLang("Tracking.GFName", "Име на зона", "GeoFence name", "Nom GeoFence");
        addLang("Tracking.AllowedInGeoFence", "Дозволени во оваа зона", "Allowed in this GeoFence", "Admis dans ce GeoFence");
        addLang("Tracking.AlertEnter", "Испрати алерт на влегување", "Send alert when entering", "Envoyer alerter lors de la saisie");
        addLang("Tracking.AlertExit", "Испрати алерт на излегување", "Send alert when exiting", "Envoyer alerter lorsque vous quittez");
        addLang("Tracking.AlertAllowEnter", "Испрати алерт кога влегува било кое од дозволените возила", "Send alert when any of allowed vehicles entering", "Envoyer une alerte lorsque des véhicules autorisés d'entrer");
        addLang("Tracking.AlertAllowExit", "Испрати алерт кога излегува било кое од дозволените возила", "Send alert when any of allowed vehicles exiting", "Envoyer une alerte lorsque des véhicules autorisés sortie");
        addLang("Tracking.AlertNotAllowEnter", "Испрати алерт кога влегува било кое од недозволените возила", "Send alert when any of not allowed vehicles entering", "Envoyer alerter quand un des véhicules non autorisés d'entrer");
        addLang("Tracking.AlertNotAllowExit", "Испрати алерт кога излегува било кое од недозволените возила", "Send alert when any of not allowed vehicles exiting", "Envoyer alerter quand un des véhicules ne sont pas admis sortant");
        addLang("Tracking.AlertEmail", "Испрати алерт на овие е-маилови", "Send alert on these emails", "Envoyer alerter sur ces e-mails");
        addLang("Tracking.AlertPhone", "Испрати алерт на овие телефонски броеви", "Send alert on these phone numbers", "Envoyer alerter sur ces numéros de téléphone");
        addLang("Tracking.Example", "Пример", "Example", "Exemple");
        addLang("Tracking.MacExample", "пример само за Македонија", "example for Macedoina only", "par exemple pour Macedoina que");
        addLang("Tracking.Company", "Компанија", "Company", "Entreprise");
        addLang("Tracking.User", "Корисник", "User", "Utilisateur");
        addLang("Tracking.GeoFenceModify", "Зоната беше успешно изменета.", "GeoFence was successfully modified.", "GeoFence a été correctement modifié.");
        addLang("Tracking.EngineOn", "Мотор ON", "Engine ON", "Moteur ON");
        addLang("Tracking.EngineOff", "Мотор OFF", "Engine OFF", "Moteur OFF");
        addLang("Tracking.EngineOffPassOn", "Мотор OFF Патници ON", "Engine OFF Passengers ON", "Les passagers le moteur ON");
        addLang("Tracking.LowSat", "Слаби сателити", "Low satellite", "Par satellite à faible");
        addLang("Tracking.Engaged", "Ангажирано", "Occupied", "Occupé");
        addLang("Tracking.TaxOffPassOn", "Таксиметар OFF Патници ON", "Taximeter OFF Passengers ON", "Taximètre les passagers dans");
        addLang("Tracking.TaxOn", "Таксиметар ON", "Taximeter ON", "Taximètre ON");
        addLang("Tracking.Engaged1", "Ангажирани", "Occupied", "Ocuppe");
        addLang("Tracking.ShowHideAllVeh", "Прикажи/Скриј ја траекторијата за сите возила", "Show/Hide trajectory for all vehicles", "Afficher / Masquer la trajectoire pour tous les véhicules");
        addLang("Tracking.ShowHideVeh", "Прикажи/Скриј ја траекторијата за возила", "Show/Hide trajectory for the vehicles", "Afficher / Masquer la trajectoire pour les véhicules");
        addLang("Tracking.QuickView", "Брз поглед", "Quick view", "Vue rapide");
        addLang("Tracking.VehDetails", "Детали за возилата", "Vehicles details", "Véhicules de détails");
        addLang("Tracking.Passengers", "Патници", "Passengers", "Passagers");
        addLang("Tracking.Taximeter", "Таксиметар", "Taximeter", "Taximètre");
        addLang("Tracking.Speed", "Брзина", "Speed", "Vitesse");
        addLang("Tracking.AddGroup", "Додади група", "Add group", "Ajouter un groupe");
        addLang("Tracking.DeletePoi", "Избриши точка од интерес", "Delete POI", "Supprimer POI");
        addLang("Tracking.DrawArea", "Цртање на зони", "Drawing areas", "Zones de dessin");
        addLang("Tracking.DeleteGF", "Бришење на зони", "Delete GeoFence", "Supprimer GeoFence");
        addLang("Tracking.Add", "Додади", "Add", "Ajouter");
        addLang("Tracking.Cancel", "Откажи", "Cancel", "Annuler");
        addLang("Tracking.ClickToChange", "Притисни за ангажирање/неангажирање на возило", "Click to change engaged status of vehicle ", "Cliquez ici pour changer le statut de véhicule engagés");
        addLang("Tracking.ClickToFind", "Притисни за наоѓање на возилото број", "Click to find vehicle number ", "Cliquez pour trouver le numéro du véhicule");
        addLang("Tracking.geofence", "Зона", "GeoFence", "GeoFence");
        addLang("Tracking.Yes", "Да", "Yes", "Oui");
        addLang("Tracking.No", "Не", "No", "Non");
        addLang("Tracking.Inactive", "Неактивни возила", "Inactive vehicles", "Véhicules inactifs");
        addLang("Tracking.Deactive", "Деактивирај", "Deactivate", "Désactiver");
        addLang("Tracking.Active", "Активирај", "Activate", "Activer");
        addLang("Tracking.Fuel", "Гориво", "Fuel", "Carburant");
        addLang("Tracking.Driver", "Возач", "Driver", "Conducteur");
        addLang("Tracking.Enter", "Внесете", "Enter", "Entrer");
        addLang("Tracking.ComingSoon", "Наскоро...", "Coming soon...", "Bientôt...");
        addLang("Tracking.Litres", "Литри", "Litres", "Litres");
        addLang("Tracking.Amount", "Износ", "Amount", "Montant");
        addLang("Tracking.SelectDriver", "Изберете возач", "Select the driver", "Sélectionnez le pilote");
        addLang("Tracking.InsertFuel", "Успешно внесени податоци за горивото!!!", "Successfully entered data on fuel!!!", "Des données entré avec succès sur le carburant!!!");

        addLang("Tracking.Error", "Грешка !!!", "Error !!!", "Erreur!!!");
        addLang("Tracking.ThePoi", "Точката од интерес ", "The point of interest ", "Le point d'intérêt");
        addLang("Tracking.SucAdd", " беше успешно додадена!!!", " was successfully added!!!", "a été ajouté avec succès!!!");
        addLang("Tracking.SucUpd", " беше успешно ажурирана!!!", " was successfully updated!!!", "a été correctement mis à jour!!!");
        addLang("Tracking.TheGroup", "Групата ", "The group ", "Le groupe");
        addLang("Tracking.WrongPass", "Погрешна лозинка !!! ", "Wrong password !!!", "Mot de passe incorrect!!!");
        addLang("Tracking.Group", "Група ", "Group ", "Groupe");
        addLang("Tracking.SucDelPoi", "Точката од интерес беше успешно избришана!!!", "The point of interest was successfully deleted!!!", "Le point d'intérêt a été supprimé avec succès!");
        addLang("Tracking.Radius", "Радиус ", "Radius ", "Rayon ");
        addLang("Tracking.SelectRadius", "Изберете радиус", "Please select radius", "S'il vous plaît sélectionner le rayon");
        addLang("Tracking.Meters", "метри", "meters", "mètres");
        addLang("Tracking.Settings", "Подесувања", "Settings", "Paramètres");
        addLang("Tracking.POI", "Точка од интерес", "Point of interest", "Point d`intérêt");
        addLang("Tracking.Street", "Улица", "Street", "Rue");
        addLang("Tracking.GFVeh", "Зона во која што се наоѓа возилото", "Zone in which the vehicle is", "Zone dans laquelle le véhicule est");

        addLang("Settings.Reports", "Извештаи", "Reports", "Raports");
        addLang("Settings.NoVeh", "Број на возило", "Number of vehicle", "Nombre de véhicule");
        addLang("Settings.DeleteSch", "Избриши го овој распоред !!!", "Delete this schedule !!!", "Supprimer ce calendrier!!!");
        addLang("Settings.DeleteAllSch", "Избриши ги сите распореди за корисникот !!!", "Delete all schedules for the user !!!", "Supprimer toutes les annexes pour l'utilisateur!");
        addLang("Settings.SpeedLimitExcess", "Надминување на дозволената брзина", "Speed limit excess", "Excès de vitesse limite");
        addLang("Settings.Delete", "Избриши", "Delete", "Effacer");
        addLang("Settings.DelAllAlarms", "ИЗбриши ги сите аларми за ова возило !!!", "Delete all alarms for this vehicle !!!", "Supprimer toutes les alarmes pour ce véhicule!!!");
        addLang("Settings.DelSpeedLimit", "ИЗбриши го ограничувањето на брзината за ова возило !!!", "Delete speed limit for this vehicle !!!", "Supprimer la limite de vitesse pour ce véhicule!!!");
        addLang("Settings.Registration", "Регистрација", "Registration", "Inscription");

        addLang("Settings.AddPoi", "Додади точка од интерес", "Add POI", "Ajouter POI");
        addLang("Settings.ViewPoi", "Види точка од интерес", "View POI", "Voir POI");
        addLang("Settings.AddGeoFence", "Додади зона", "Add GeoFence", "Ajouter GeoFence");
        addLang("Settings.ViewGeoFence", "Види зона", "View GeoFence", "Voir Geofence");
        addLang("Settings.LiveTracking", "Следење во живо", "Live tracking", "Live de suivi");
        addLang("Settings.AddSpeedLimit", "Додади ограничување на брзината !", "Add speed limit !", "Ajouter la limite de vitesse !");

        addLang("Settings.DelAllAlarms", "Избриши ги сите аларми за зоните за ова возило !!!", "Delete all GeoFence alarms for this vehicle !!!", "Supprimer toutes les alarmes Géofence pour ce véhicule!!!");
        addLang("Settings.DelAlarm", "Избриши го овој аларм за зона за ова возило !!!", "Delete this GeoFence alarm for this vehicle !!!", "Supprimer cette alarme GeoFence pour ce véhicule!!!");
        addLang("Settings.MustSel", "Мора да изберете IN или OUT зона !!!", "Must select IN or OUT GeoFence !!!", "Vous devez sélectionner IN ou OUT GeoFence !!!");

        addLang("Settings.SummReports", "Сумарни извештаи", "Summary reports", "Les rapports de synthèse");
        addLang("Settings.Dashboard", "Dashboard", "Dashboard", "Tableau de bord");
        addLang("Settings.FleetReport", "Извештај за флотата на возила", "Fleet report", "Flotte rapport");
        addLang("Settings.VehicleReports", "Извештаи за возилата", "Vehicle reports", "Rapports des véhicules");
        addLang("Settings.Overview", "Преглед", "Overview", "Vue d'ensemble");
        addLang("Settings.ShortReport", "Краток извештај", "Short report", "Bref rapport");
        addLang("Settings.DetailReport", "Детален извештај", "Detail report", "Rapport détaillé");
        addLang("Settings.VisitedPoi", "Посетени точки од интерес", "Visited POI", "POI visité");
        addLang("Settings.Reconstruction", "Реконструкција", "Reconstruction", "La reconstruction");

        addLang("Settings.TaxiReport", "Такси извештај", " Taxi report", "Rapport Taxi");
        addLang("Settings.GeoFenceReport", "Извештај за зони", "GeoFence report)", "Rapport GeoFence");
        addLang("Settings.Analysis", "Анализи", "Analysis", "Analyse");
        addLang("Settings.DistTrav", "Поминато растојание", "Distance travelled", "Distance parcourue");
        addLang("Settings.Activity", "Активност", "Activity", "Activité");
        addLang("Settings.MaxSpeed", "Максимална брзина", "Max speed", "Vitesse maxi");

        addLang("Settings.SpeedLimitExcess", "Надминување на дозволената брзина", "Speed limit excess", "Excès de vitesse limite");
        addLang("Settings.Export", "Пренос", "Export", "Exporter");
        addLang("Settings.ExportExcel", "Пренос во Excel", "Export to Excel", "Exporter vers Excel");
        addLang("Settings.ExportPdf", "Пренос во PDF", "Export to PDF", "Exporter vers PDF");
        addLang("Settings.SendMail", "Испрати на е-маил", "Send to e-mail", "Envoyer un e-mail");
        addLang("Settings.ScheduleRep", "Распоред на извештај", "Schedule report", "L'annexe du rapport");

        addLang("Settings.Settings", "Подесувања", "Settings", "Paramètres");

        addLang("Settings.GeneralSett", "Општи подесувања", "General settings", "Paramètres généraux");

        addLang("Settings.Privileges", "Привилегии", "Privileges", "Privilèges");
        addLang("Settings.Poi", "Точка од интерес", "Point of interest", "Point d'intérêt");
        addLang("Settings.GeoFence", "Зона", "GeoFence", "GeoFence");

        addLang("Settings.InGeoFence", "Во зона", "In GeoFence", "En GeoFence");
        addLang("Settings.OutGeoFence", "Надвор од зона", "Out GeoFence", "Out GeoFence");
        addLang("Settings.AddSchedule", "Додади распоред", "Add schedule", "Ajouter planifier");
        addLang("Settings.SaveSettings", "Сними подесувања", "Save Settings", "Enregistrer les paramètres");

        addLang("Settings.Note", "Забелешка", "Note", "Noter");
        addLang("Settings.SetPriv", "Привилегија може да се подеси само на корисниците кои имаат (УЛОГА КОРИСНИК) !!!", "Privilege can be set only to users who have (ROLE USER) !!!", "Privilège peut être réglé uniquement aux utilisateurs qui ont (rôle d'utilisateur)!!!");

        addLang("Settings.Vehicle", "Возило", "Vehicle", "Véhicule");
        addLang("Settings.AllVehicles", "Сите возила", "All vehicles", "Tous les véhicules");
        addLang("Settings.Period", "Период", "Period", "Période");

        addLang("Settings.Daily", "Дневно", "Daily", "Quotidien");
        addLang("Settings.Weekly", "Неделно", "Weekly", "Hebdomadaire");
        addLang("Settings.Monthly", "Месечно", "Monthly", "Mensuel");
        addLang("Settings.Day", "Ден", "Day", "Jour");
        addLang("Settings.Monday", "Понеделник", "Monday", "Lundi");
        addLang("Settings.Tuesday", "Вторник", "Tuesday", "Mardi");
        addLang("Settings.Wednesday", "Среда", "Wednesday", "Mercredi");
        addLang("Settings.Thursday", "Четврок", "Thursday", "Jeudi");
        addLang("Settings.Friday", "Петок", "Friday", "Vendredi");
        addLang("Settings.Saturday", "Сабота", "Saturday", "Samedi");
        addLang("Settings.Sunday", "Недела", "Sunday", "Dimanche");

        addLang("Settings.Time", "Време", "Time", "Temps");
        addLang("Settings.Email", "Е-маил", "E-mail", "E-mail");
        addLang("Settings.Area", "Зона", "Area", "Zone");
        addLang("Settings.AlertInGeoFence", "Алерт кога е ВО зона", "Alert when IN GeoFence", "Alertez EN GeoFence");
        addLang("Settings.AlertOutGeoFence", "Алерт кога е НАДВОР од зона", "Alert when OUT GeoFence", "Alertez OUT GeoFence");
        addLang("Settings.SuccAdd", "Успешно додадено", "Successfully added", "Vous avez joint l'");
        addLang("Settings.SuccMod", "Зоната беше успешно променета", "GeoFence was successfully modified", "GeoFence a été modifié avec succès");

        addLang("Settings.Error", "Грешка !!!", "Error !!!", "Erreur !!!");
        addLang("Settings.ThePoi", "Точката од интерес ", "The point of interest ", "Le point d'intérêt ");
        addLang("Settings.SucAdd", " беше успешно додадена.", " was successfully added.", "a été ajouté avec succès.");
        addLang("Settings.SucUpd", " беше успешно ажурирана.", " was successfully updated.", " a été mis à jour.");
        addLang("Settings.TheGroup", "Групата ", "The group ", "Le groupe ");
        addLang("Settings.WrongPass", "Погрешна лозинка !!! ", "Wrong password !!!", "Mot de passe incorrect !!!");
        addLang("Settings.Group", "Група ", "Group ", "Groupe ");

        addLang("Settings.ChangeVehSett", "Промена на возило", "Change vehicle ", "Changer de véhicule");
        addLang("Settings.UserSett", "Подесувања за корисникот", "User settings", "Les paramètres utilisateur");
        addLang("Settings.ClientType", "Тип на клиент", "Client type", "Type de client");
        addLang("Settings.HomeCity", "Град на живеење", "Home city", "Accueil ville");
        addLang("Settings.Users", "Корисници", "Users", "Utilisateurs");
        addLang("Settings.EditVeh", "Промени возило", "Edit vehicle", "Modifier véhicule");
        addLang("Settings.SuccUpd", "Успешно променето возило !", "Successfully changed vehicle !", "Véhicule modifié avec succès !");

        addLang("Settings.SpeedLimit", "Ограничување на брзината", "Speed limit", "Limitation de vitesse");
        addLang("Settings.GeoFenceExceed", "Напуштање на зона", "GeoFence abandonment", "L'abandon geofence");
        addLang("Settings.Add", "Додади", "Add", "Ajouter");
        addLang("Settings.Close", "Затвори", "Close", "Fermer");
        addLang("Settings.Edit", "Измени", "Edit", "Editer");
        addLang("Settings.Vehicles", "Возила", "Vehicles", "Véhicules");
        addLang("Settings.DelUser?", "Дали сакате да го избришете овој корисник?", "Do you want to delete this user?", "Voulez-vous supprimer cet utilisateur");
        addLang("Settings.VehicleSettings", "Подесувања за возилата", "Vehicle settings", "Paramètres pour les véhicules");
        addLang("Settings.DelUser", "Избриши корисник", "Delete user", "Supprimer un utilisateur");
        addLang("Settings.CannotDelUser", "Овој корисник не може да биде избришан !!!", "This user cannot be deleted !!!", "Cet utilisateur ne peut pas être supprimé!!!");
        addLang("Settings.EditUser", "Измени корисник", "Edit user", "Modifier l'utilisateur");
        addLang("Settings.FullName", "Цело име", "Full name", "Nom et prénom");
        addLang("Settings.UserName", "Корисничко име", "User name", "Nom d'utilisateur");
        addLang("Settings.Password", "Лозинка", "Password", "Mot de passe");
        addLang("Settings.AddUser", "Додади корисник", "Add User", "Ajouter un utilisateur");

        addLang("Settings.PanoramaGPS", "Панорама ГПС", "Panorama GPS", "Panorama GPS");
        addLang("Settings.User", "Корисник", "User", "Utilisateur");
        addLang("Settings.Company", "Компанија", "Company", "Entreprise");
        addLang("Settings.Phone", "Телефон", "Phone", "Téléphone");
        addLang("Settings.Loading", "Вчитување", "Loading", "Chargement");
        addLang("Settings.SucDel", "Зоната беше успешно избришана.", "GeoFence was successfully deleted.", "GeoFence a été supprimé avec succès.");
        addLang("Settings.SucDelPoi", "Точката од интерес беше успешно избришана.", "Point of interest was successfully deleted.", "Point d'intérêt a été supprimé avec succès.");
        addLang("Settings.SucSave", "Зоната беше успешно зачувана.", "GeoFence was successfully saved.", "GeoFence a été correctement enregistré.");
        addLang("Settings.NameGroup", "Име на група", "Name of group", "Nom du groupe");
        addLang("Settings.Color", "Боја", "Color", "Couleur");
        addLang("Settings.NameGeoFence", "Име на зона", "Name of GeoFence", "Nom de GeoFence");
        addLang("Settings.ChangeName", "Промени име", "Change name", "Changer le nom");
        addLang("Settings.DrawingAreas", "Цртање на зони", "Drawing areas", "Zones de dessin");
        addLang("Settings.NameGroup", "Име на група", "Name of group", "Nom du groupe");
        addLang("Settings.ChooseIcon", "Избери икона", "Choose icon", "Choisissez l'icône");
        addLang("Settings.AddGroup", "Додади група", "Add group", "Ajouter un groupe");
        addLang("Settings.DeletePoi", "Избриши точка од интерес", "Delete POI", "Supprimer POI");
        addLang("Settings.DeleteGeoFence", "Избриши зона", "Delete GeoFence", "Supprimer GeoFence");
        addLang("Settings.DeleteThisPoi?", "Дали сте сигурни дека сакате да ја избришете оваа точка од инетерес?", "Are you sure to want to delete this point of interest?", "Etes-vous sûr de vouloir supprimer ce point d'intérêt?");
        addLang("Settings.DeleteThisGeoFence?", "Дали сте сигурни дека сакате да ја избришете оваа зона?", "Are you sure to want to delete this GeoFence?", "Etes-vous sûr de vouloir supprimer ce GeoFence?");

        addLang("Settings.Latitude", "Географска ширина", "Latitude", "Latitude");
        addLang("Settings.Longitude", "Географска должина", "Longitude", "Longitude");
        addLang("Settings.Address", "Адреса", "Address", "Adresse");
        addLang("Settings.NamePoi", "Име на точка од интерес", "Name of POI", "Nom du POI");
        addLang("Settings.AddInfo", "Дополнителни информации", "Additional info", "Informations complémentaires");
        addLang("Settings.AvailableFor", "Достапни за", "Available for", "Disponible pour");
        addLang("Settings.OnlyMe", "Само мене", "Only me", "Seulement moi");
        addLang("Settings.AllUsers", "Сите корисници", "All Users", "Tous les utilisateurs");
        addLang("Settings.CannotChange", "Без промена", "Can't change", "Impossible de changer");
        addLang("Settings.Group", "Група", "Group", "Groupe");
        addLang("Settings.SelectGroup", "Ве молиме изберете група", "Please select group", "S'il vous plaît sélectionner le groupe");

        addLang("Settings.GeoFenceName", "Име на зона", "GeoFence name", "Nom GeoFence");
        addLang("Settings.AllowedInGeoFence", "Дозволени во оваа зона", "Allowed in this GeoFence", "Admis dans ce GeoFence");
        addLang("Settings.AlertEnter", "Испрати алерт на влегување", "Send alert when entering", "Envoyer alerter lors de la saisie");
        addLang("Settings.AlertExit", "Испрати алерт на излегување", "Send alert when exiting", "Envoyer alerter lorsque vous quittez");

        addLang("Settings.AlertAllowEnter", "Испрати алерт кога влегува било кое од дозволените возила", "Send alert when any of allowed vehicles entering", "Envoyer une alerte lorsque des véhicules autorisés d'entrer");
        addLang("Settings.AlertAllowExit", "Испрати алерт кога излегува било кое од дозволените возила", "Send alert when any of allowed vehicles exiting", "Envoyer une alerte lorsque des véhicules autorisés sortie");
        addLang("Settings.AlertNotAllowEnter", "Испрати алерт кога влегува било кое од недозволените возила", "Send alert when any of not allowed vehicles entering", "Envoyer alerter quand un des véhicules non autorisés d'entrer");
        addLang("Settings.AlertNotAllowExit", "Испрати алерт кога излегува било кое од недозволените возила", "Send alert when any of not allowed vehicles exiting", "Envoyer alerter quand un des véhicules ne sont pas admis sortant");
        addLang("Settings.AlertEmail", "Испрати алерт на овие е-маилови", "Send alert on these emails", "Envoyer alerter sur ces e-mails");
        addLang("Settings.AlertPhone", "Испрати алерт на овие телефонски броеви", "Send alert on these phone numbers", "Envoyer alerter sur ces numéros de téléphone");
        addLang("Settings.Example", "Пример", "Example", "exemple");
        addLang("Settings.MacExample", "пример само за Македонија", "example for Macedonia only", "Par exemple pour la Macédoine ne");
        addLang("Settings.SpeedLimitExceed", "Надминување на дозволената брзина", "Speed limit exceed", "La limite de vitesse dépasse");
        addLang("Settings.SelectAll", "Избери ги сите", "Select all", "Sélectionnez tous les");
        addLang("Settings.Groups", "Групи", "Groups", "Groupes");
        addLang("Settings.GeneralGroup", "општа група", "general group", "Générale du groupe");
        addLang("Settings.View", "Прикажи", "View", "Voir");
        addLang("Settings.ChangeGroup", "Промени група", "Change group", "Changement de groupe");
        addLang("Settings.EditGroup", "Измени група", "Edit group", "Modifier le groupe");
        addLang("Settings.DeleteGroup", "ИЗбриши група", "Delete Group", "Supprimer le groupe");
        addLang("Settings.EditPoi", "Измени точка од интерес", "Edit Point of Interest", "Modifier point d'intérêt");
        addLang("Settings.DeletePoi", "Избриши точка од интерес", "Delete Point of Interest", "Supprimer le point d'intérêt");

        addLang("Settings.Change", "Промени", "Change", "Changer");
        addLang("Settings.Yes", "Да", "Yes", "Oui");
        addLang("Settings.No", "Не", "No", "Non");

        addLang("Settings.ShowGeoFence", "Прикажи зона", "Show GeoFence", "Afficher GeoFence");
        addLang("Settings.EditGeoFence", "Измени зона", "Edit GeoFence", "Modifier GeoFence");
        addLang("Settings.DeleteGeoFence", "Избриши зона", "Delete GeoFence", "Supprimer GeoFence");
        addLang("Settings.DeleteGroup?", "Дали сакате да ја избришете оваа група?", "Do you want to delete this group?", "Voulez-vous supprimer ce groupe?");
        addLang("Settings.DeletePoi?", "Дали сакате да ја избришете оваа точка од интерес?", "Do you want to delete this Point of Interest?", "Voulez-vous supprimer ce point d'intérêt?");
        addLang("Settings.DeleteGeoFence?", "Дали сакате да ја избришете оваа зона?", "Do you want to delete this GeoFence?", "Voulez-vous supprimer ce GeoFence?");
        addLang("Settings.ShowPoi", "Прикажи го точките од интерес", "Show Points of Interest", "Afficher les points d'intérêt");
        addLang("Settings.AllowedVeh", "Дозволени возила", "Allowed vehicles", "Véhicules autorisés");
        addLang("Settings.SucUpdGeoFenceName", "Името на зоната беше успешно ажурирано.", "GeoFence name was successfully updated.", "Nom GeoFence a été correctement mis à jour.");
        addLang("Settings.SaveAppSett", "Зачувај ги подесувањата на апп.", "Save app. settings", "Enregistrer app. paramètres");
        addLang("Settings.Local", "Локално", "Local", "Local");
        addLang("Settings.Global", "Глобално", "Global", "Mondial");
        addLang("Settings.None", "Никако", "Absolutely not", "Absolument pas");
        addLang("Settings.AvailableMaps", "Достапни мапи", "Available maps", "Les cartes disponibles");
        addLang("Settings.DefLang", "Стандарден јазик", "Default language", "La langue par défaut");
        addLang("Settings.En", "Англиски", "English", "Anglais");
        addLang("Settings.Mk", "Македонски", "Macedonian", "Macédonienne");
        addLang("Settings.Fr", "Француски", "French", "Français");
        addLang("Settings.DefMap", "Стандардна мапа", "Default map", "La carte par défaut");
        addLang("Settings.DateFormat", "Формат на датумот", "Date format", "Le format de date");
        addLang("Settings.TimeFormat", "Формат на времето", "Time format", "Format de l'heure");
        addLang("Settings.24Time", "24 часа", "24 Hour Time", "24 Temps Heure");
        addLang("Settings.12Time", "12 часа", "12 Hour Time", "12 Temps Heure");
        addLang("Settings.ShowInfoMess", "Прикажи ја инфо пораката", "Show info message", "Voir le message d'info");
        addLang("Settings.OnOff", "ON/OFF", "ON/OFF", "marche / arrêt");
        addLang("Settings.DateTime", "Датум и време", "Date time", "Date et heure");
        addLang("Settings.Speed", "Брзина", "Speed", "Vitesse");
        addLang("Settings.Location", "Локација", "Location", "Emplacement");
        addLang("Settings.Trace", "Трага", "Trace", "Tracer");
        addLang("Settings.Min", "Мин", "Min", "Ma");
        addLang("Settings.Zone", "Зона", "Zone", "Zone");
        addLang("Settings.Passengers", "Патници", "Passengers", "Passagers");
        addLang("Settings.Taximeter", "Таксиметар", "Taximeter", "Taximètre");
        addLang("Settings.Fuel", "Гориво", "Fuel", "Carburant");
        addLang("Settings.DistRep", "Претставување на растојанието", "Distance represent", "Distance représentent");
        addLang("Settings.Metric", "Метрички", "Metric", "Métrique");
        addLang("Settings.Imperial", "Империјално", "Imperial", "Impérial");

        addLang("Settings.VehColors", "Бои на возила", "Vehicles colors", "Véhicules couleurs");
        addLang("Settings.EngineOn", "Мотор ON", "Engine ON", "Moteur ON");
        addLang("Settings.EngineOff", "Мотор OFF", "Engine OFF", "Moteur OFF");
        addLang("Settings.EngineOffPassOn", "Мотор OFF Патници ON", "Engine OFF Passengers ON", "Les passagers le moteur ON");
        addLang("Settings.LowSat", "Слаби сателити", "Low satellite", "Par satellite à faible");
        addLang("Settings.Engaged", "Ангажирано", "Occupied", "Occupé");
        addLang("Settings.TaxOffPassOn", "Таксиметар OFF Патници ON", "Taximeter OFF Passengers ON", "Taximètre les passagers dans");
        addLang("Settings.TaxOn", "Таксиметар ON", "Taximeter ON", "Taximètre ON");

        addLang("Settings.LightBlue", "Светло сина", "Light blue", "Lumière bleue");
        addLang("Settings.Red", "Црвена", "Red", "Rouge");
        addLang("Settings.DarkBlue", "Темно сина", "Dark blue", "Le bleu foncé");
        addLang("Settings.Green", "Зелена", "Green", "Vert");
        addLang("Settings.Yellow", "Жолта", "Yellow", "Jaune");
        addLang("Settings.Gray", "Сива", "Gray", "Gris");
        addLang("Settings.Black", "Црна", "Black", "Noir");
        addLang("Settings.Orange", "Портокалова", "Orange", "Orange");
        addLang("Settings.RedBlue", "Црвено сина", "Red blue", "Rouge bleu");

        addLang("Settings.GeoFences", "Зони", "GeoFence", "GeoFence");
        addLang("Settings.Pois", "Точки од интерес", "Points of interest", "Points d'intérêt");
        addLang("Settings.Poi1", "ТОИ", "POI", "POI");
        



        addLang("Main.SessionExpired", "Сесијата заврши", "Session expired", "Session a été expirée");
        addLang("Main.ClickLogin", "Кликнете тука за да се најавите повторно", "Click here to login again", "Cliquez ici pour vous connecter à nouveau");

		addLang("", "", "", "");
		addLang("", "", "", "");
		addLang("", "", "", "");
		addLang("", "", "", "");
		
	
?>