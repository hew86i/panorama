// JavaScript Document

function gnMapsSet(){
	
	// Variables
	this.Items = new Object();
	this.Citis = new Object();
	this.ItemsMK = new Object();
	this.ItemsKS = new Object();

	// Mapset Structure
	this.sMapSet = function (ZoomLevel, pointAX, pointAY, pointBX, pointBY, widthPx, heightPx, backColor, facX, facY) {
	    this.ZoomLevel = ZoomLevel;
	    this.pointAX = pointAX;
	    this.pointAY = pointAY;
	    this.pointBX = pointBX;
	    this.pointBY = pointBY;
	    this.widthPx = widthPx;
	    this.heightPx = heightPx;
	    this.backColor = backColor;
	    this.facX = facX;
	    this.facY = facY;
	};
	
	this.sCity = function(cName, cLon, cLat, cReg, cZoom5, cZoom6){
		this.cName = cName;
		this.cLon = cLon;
		this.cLat = cLat;
		this.cReg = cReg;
		this.cZoom5 = cZoom5;
		this.cZoom6 = cZoom6;
		
	};

	// Citis Centers
	this.Citis[0] = new this.sCity('Kavadarci',22.0105 ,41.4311 ,'KV', 15, 16);
	this.Citis[1] = new this.sCity('Kumanovo',21.719 ,42.1371 ,'KU', 9, 10);
	this.Citis[2] = new this.sCity('Skopje',21.4315 ,41.9959 ,'SK', 7, 8);
	this.Citis[3] = new this.sCity('Tetovo',20.967 ,42.007 ,'TE', 13, 14);
	this.Citis[4] = new this.sCity('Prilep',21.555 ,41.345 ,'PR', 17, 18);
	this.Citis[5] = new this.sCity('Delcevo',22.7721 ,41.9657 ,'DE', 19, 20);
	this.Citis[6] = new this.sCity('Struga',20.6787 ,41.179 ,'SG', 21, 22);
	this.Citis[7] = new this.sCity('Strumica',22.6428 ,41.4361 ,'ST', 23, 24);
	this.Citis[8] = new this.sCity('Stip',22.198 ,41.7433 ,'SP', 25, 26);
	this.Citis[9] = new this.sCity('Veles',21.775 ,41.713 ,'VE', 27, 28);
	this.Citis[10] = new this.sCity('Bitola',21.3342 ,41.0328 ,'BT', 29, 30);
	this.Citis[11] = new this.sCity('Gevgelija',22.5009 ,41.143 ,'GV', 31, 32);
	this.Citis[12] = new this.sCity('Gostivar',20.9079 ,41.7952 ,'GS', 11, 12);
	this.Citis[13] = new this.sCity('Negotino',22.0893 ,41.4829 ,'NG', 33, 34);
	this.Citis[14] = new this.sCity('Ohrid',20.809 ,41.1159 ,'OH', 35, 36);
	this.Citis[15] = new this.sCity('Berovo',22.8542 ,41.7079 ,'BR', 69, 70);
	this.Citis[16] = new this.sCity('Vinica', 22.506947, 41.882808, 'VN', 49, 50);
	this.Citis[17] = new this.sCity('Pehcevo',22.8882 ,41.7627 ,'PH', 73, 74);
	this.Citis[18] = new this.sCity('Resen', 21.012206, 41.089544, 'RE', 47, 48);
	this.Citis[19] = new this.sCity('Kicevo', 20.960047, 41.512686, 'KC', 43, 44);
	this.Citis[20] = new this.sCity('Radovis',22.4661 ,41.6384 ,'RD', 63, 64);
	this.Citis[21] = new this.sCity('Rek', 21.513736, 41.047353, 'RK', 37, 38);
	this.Citis[22] = new this.sCity('DemirHisar', 21.202622, 41.222014, 'DH', 39, 40);
	this.Citis[23] = new this.sCity('MBrod', 21.215419, 41.514628, 'MB', 41, 42);
	this.Citis[24] = new this.sCity('Krusevo', 21.249239, 41.369103, 'KR', 45, 46);
	this.Citis[25] = new this.sCity('Pristina', 21.162057, 42.659546, 'KP', 51, 52);
	this.Citis[26] = new this.sCity('Pec', 20.29345, 42.657779, 'PE', 53, 54);
	this.Citis[27] = new this.sCity('Prizren', 20.730844, 42.207878, 'PN', 55, 56);
	this.Citis[28] = new this.sCity('KMitrovica', 20.865598, 42.879442, 'KM', 57, 58);
	this.Citis[29] = new this.sCity('Gjakovica', 20.430093, 42.38285, 'GJ', 59, 60);
	this.Citis[30] = new this.sCity('Urosevac', 21.153989, 42.370486, 'UR', 61, 62);
	this.Citis[31] = new this.sCity("Feni", 21.994965, 41.169554, "FN", 65, 66);
	this.Citis[32] = new this.sCity("Kocani", 22.410979, 41.916732, "KN", 67, 68);
	this.Citis[33] = new this.sCity("SvNikole", 21.939182, 41.866192, "SN", 71, 72);

	//this.Items[0] = new this.sMapSet('450MK', 18.498781, 39.872125, 23.28, 44.239989, 3072, 3072, '#f2efe9', 30, -15);
	
	//24.428544
	// Mapset Macedonia
	//this.Items[1]=new this.sMapSet('300GT', 19.25, 40.09, 23.28, 43.074739, 2048, 2048, '#f2efe9', 30, -15);
	//this.ItemsMK[0] = new this.sMapSet('300GT', 19.343519, 40.141358, 24.256608, 43.035339, 2560, 2048, '#f2efe9', 0, 0);
	
	this.ItemsMK[1] = new this.sMapSet('100GT', 20.407422, 40.649336, 23.470995, 42.576637, 7168, 6144, '#ebdec1', 0, 0);
	this.ItemsMK[2] = new this.sMapSet('50GT', 20.407425, 40.649064, 23.690671, 42.571305, 15360, 12288, '#ebdec1', 0, 0);
	this.ItemsMK[3] = new this.sMapSet('20GT', 20.407422, 40.649446, 23.470822, 42.576641, 35840, 30720, '#ebdec1', 0, 0);
	this.ItemsMK[4] = new this.sMapSet('10SK', 21.271234, 41.887971, 21.569289, 42.108128, 4096, 4096, '#ebdec1', 0, 0);
	this.ItemsMK[5] = new this.sMapSet('5SK', 21.321107, 41.915565, 21.551232, 42.080626, 17920, 17408, '#ebdec1', 0, 0);
	// Mapset kosovo
	//this.Items[1]=new this.sMapSet('450KS', 18.554283, 41.085833, 23.507056, 44.010036, 2560, 2048, '#f2efe9', 30, -15);
	this.ItemsKS[1] = new this.sMapSet('100KO', 19.92608, 41.82300, 21.90447, 43.28674, 4608, 4608, '#ebdec1', 30, -15);
	this.ItemsKS[2] = new this.sMapSet('50KO', 19.92608, 41.82300, 21.90447, 43.28845, 9216, 9216, '#ebdec1', 30, -15);
	this.ItemsKS[3] = new this.sMapSet('50KO', 19.92608, 41.82300, 21.90447, 43.28845, 9216, 9216, '#ebdec1', 30, -15);
	this.ItemsKS[4] = new this.sMapSet('50KO', 19.92608, 41.82300, 21.90447, 43.28845, 9216, 9216, '#ebdec1', 30, -15);


	this.Items[0] = new this.sMapSet('450GT', 18.498781, 39.872125, 24.428544, 44.239989, 3072, 3072, '#f2efe9', 30, -15);	
	
	this.Items[1] = new this.sMapSet('100KO', 19.92608, 41.82300, 21.90447, 43.28674, 4608, 4608, '#f2efe9', 30, -15);
	this.Items[2] = new this.sMapSet('50KO', 19.92608, 41.82300, 21.90447, 43.28845, 9216, 9216, '#ebdec1', 30, -15);
	this.Items[3] = new this.sMapSet('100KO', 19.92608, 41.82300, 21.90447, 43.28674, 4608, 4608, '#f2efe9', 30, -15); 		
	this.Items[4] = new this.sMapSet('50KO', 19.92608, 41.82300, 21.90447, 43.28845, 9216, 9216, '#ebdec1', 30, -15);


	this.Items[5] = new this.sMapSet('10SK', 21.271234, 41.887971, 21.569289, 42.108128, 4096, 4096, '#ebdec1', 0, 0);
	this.Items[6] = new this.sMapSet('5SK', 21.321107, 41.915565, 21.551232, 42.080626, 17920, 17408, '#ebdec1', 0, -10);  	

	//Skopje
	this.Items[7] = new this.sMapSet('10SK', 21.271234, 41.887971, 21.569289, 42.108128, 4096, 4096, '#ebdec1', 0, 0);
	this.Items[8] = new this.sMapSet('5SK', 21.321107, 41.915565, 21.551232, 42.080626, 17920, 17408, '#ebdec1', 0, -10);

	//Kumanovo
	this.Items[9] = new this.sMapSet('10KU', 21.6725, 42.0997, 21.7606, 42.1642, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[10] = new this.sMapSet('5KU', 21.6812, 42.1198, 21.7405, 42.1438, 4608, 2560, '#ebdec1', 0, 0);

	//Gostivar
	this.Items[11] = new this.sMapSet('10GS', 20.8436, 41.7441, 20.9739, 41.8418, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[12] = new this.sMapSet('5GS', 20.8436, 41.7441, 20.9739, 41.841867, 9216, 9216, '#ebdec1', 0, 0);

	//Tetovo
	this.Items[13] = new this.sMapSet('10TE', 20.9207, 41.9695, 21.0166, 42.0411, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[14] = new this.sMapSet('5TE', 20.9228, 41.9711, 21.0144, 42.0395, 7168, 7168, '#ebdec1', 0, 0);

	//Kavadarci
	this.Items[15] = new this.sMapSet('10KV', 21.9528, 41.3883, 22.0709, 41.4751, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[16] = new this.sMapSet('5KV', 21.9724, 41.4028, 22.0512, 41.4607, 6144, 6144, '#ebdec1', 0, 0);


	//Prilep
	this.Items[17] = new this.sMapSet('10PR', 21.4878, 41.2971, 21.6195, 41.3950, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[18] = new this.sMapSet('5PR', 21.5080, 41.3121, 21.5993, 41.3800, 7168, 7168, '#ebdec1', 0, 0);

	//Delcevo
	this.Items[19] = new this.sMapSet('10DE', 22.7486, 41.9482, 22.7975, 41.9832, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[20] = new this.sMapSet('5DE', 22.7562, 41.9538, 22.7961, 41.9776, 3072, 2560, '#ebdec1', 0, 0);

	//Struga
	this.Items[21] = new this.sMapSet('10SG', 20.6436, 41.1511, 20.7208, 41.2099, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[22] = new this.sMapSet('5SG', 20.6436, 41.1511, 20.7208, 41.2099, 6144, 6144, '#ebdec1', 0, 0);

	//Strumica
	this.Items[23] = new this.sMapSet('10ST', 22.5961, 41.4029, 22.6842, 41.4667, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[24] = new this.sMapSet('5ST', 22.6248, 41.4187, 22.6580, 41.4507, 1536, 2048, '#ebdec1', 0, 0);

	//Stip
	this.Items[25] = new this.sMapSet('10SP', 22.1277, 41.6952, 22.2664, 41.7962, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[26] = new this.sMapSet('5SP', 22.1277, 41.6952, 22.2664, 41.7962, 10752, 10752, '#ebdec1', 0, 0);

	//Veles
	this.Items[27] = new this.sMapSet('10VE', 21.7028, 41.6617, 21.8474, 41.7681, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[28] = new this.sMapSet('5VE', 21.7290, 41.6811, 21.8211, 41.7488, 7168, 7168, '#ebdec1', 0, 0);

	//Bitola
	this.Items[29] = new this.sMapSet('10BT', 21.2562, 40.9772, 21.3986, 41.0841, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[30] = new this.sMapSet('5BT', 21.2820, 40.9967, 21.3726, 41.0647, 7168, 7168, '#ebdec1', 0, 0);

	//Gevgelija
	this.Items[31] = new this.sMapSet('10GV', 22.4425, 41.0998, 22.5607, 41.1861, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[32] = new this.sMapSet('5GV', 22.4425, 41.0998, 22.5607, 41.1861, 9216, 9216, '#ebdec1', 0, 0);

	//Negotino
	this.Items[33] = new this.sMapSet('10NG', 22.0313, 41.4433, 22.1496, 41.5301, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[34] = new this.sMapSet('5NG', 22.0510, 41.4578, 22.1298, 41.5156, 6144, 6144, '#ebdec1', 0, 0);

	//Ohrid
	this.Items[35] = new this.sMapSet('10OH', 20.7326, 41.0656, 20.8743, 41.1732, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[36] = new this.sMapSet('5OH', 20.7583, 41.0852, 20.8485, 41.1537, 7168, 7168, '#ebdec1', 0, 0);

	//Rek Bitola
	this.Items[37] = new this.sMapSet('10RK', 21.447031, 40.997550, 21.5767, 41.0946, 2048, 2048, '#ebdec1', 0, 0);
	this.Items[38] = new this.sMapSet('5RK', 21.4470, 40.9975, 21.5767, 41.0945, 3072, 3072, '#ebdec1', 0, 0);

    //Demir Hisar
	this.Items[39] = new this.sMapSet('10DH', 21.147729, 41.1768613, 21.264369, 41.264513, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[40] = new this.sMapSet('5DH', 21.147729, 41.1768613, 21.264369, 41.264513, 6144, 6144, '#ebdec1', 0, 0);

	//Makedonski Brod
	this.Items[41] = new this.sMapSet('10MB', 21.157811, 41.470414, 21.274992, 41.558049, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[42] = new this.sMapSet('5MB', 21.157811, 41.470414, 21.274992, 41.558049, 6144, 6144, '#ebdec1', 0, 0);

	//Kicevo
	this.Items[43] = new this.sMapSet('10KC', 20.899686, 41.467025, 21.016514, 41.554925, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[44] = new this.sMapSet('5KC', 20.899686, 41.467025, 21.016514, 41.554925, 9216, 9216, '#ebdec1', 0, 0);

	//Krusevo
	this.Items[45] = new this.sMapSet('10KR', 21.191303, 41.325806, 21.308268, 41.413411, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[46] = new this.sMapSet('5KR', 21.191303, 41.325806, 21.308268, 41.413411, 6144, 6144, '#ebdec1', 0, 0);

	//Resen
	this.Items[47] = new this.sMapSet('10RE', 20.954214, 41.045514, 21.070364, 41.133364, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[48] = new this.sMapSet('5RE', 20.954214, 41.045514, 21.070364, 41.133364, 9216, 9216, '#ebdec1', 0, 0);

	//Vinica
	this.Items[49] = new this.sMapSet('10VN', 22.448761, 41.838742, 22.568344, 41.925019, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[50] = new this.sMapSet('5VN', 22.448761, 41.838742, 22.568344, 41.925019, 9216, 9216, '#ebdec1', 0, 0);

    //KOSOVO
	//Pristina
	this.Items[51] = new this.sMapSet('10KP', 21.105244, 42.622842, 21.2245, 42.710508, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[52] = new this.sMapSet('5KP', 21.125097, 42.637461, 21.2046, 42.695905, 6144, 6144, '#ebdec1', 0, 0);

	//Pec
	this.Items[53] = new this.sMapSet('10PE', 20.235497, 42.613128, 20.3535, 42.701694, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[54] = new this.sMapSet('5PE', 20.235497, 42.613128, 20.3535, 42.701694, 9216, 9216, '#ebdec1', 0, 0);

    //Prizren
	this.Items[55] = new this.sMapSet('10PN', 20.678119, 42.170833, 20.795928, 42.25895, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[56] = new this.sMapSet('5PN', 20.678119, 42.170833, 20.795928, 42.25895, 9216, 9216, '#ebdec1', 0, 0);

	//Kosovska Mitrovica
	this.Items[57] = new this.sMapSet('10KM', 20.807925, 42.839939, 20.927178, 42.927911, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[58] = new this.sMapSet('5KM', 20.807925, 42.839939, 20.927178, 42.927911, 9216, 9216, '#ebdec1', 0, 0);

	//Kosovska Mitrovica
	this.Items[59] = new this.sMapSet('10GJ', 20.372436, 42.338661, 20.490125, 42.427086, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[60] = new this.sMapSet('5GJ', 20.372436, 42.338661, 20.490125, 42.427086, 9216, 9216, '#ebdec1', 0, 0);

	//Urosevac
	this.Items[61] = new this.sMapSet('10UR', 21.096572, 42.325314, 21.215253, 42.412997, 3072, 3072, '#ebdec1', 0, 0);
	this.Items[62] = new this.sMapSet('5UR', 21.096572, 42.325314, 21.215253, 42.412997, 9216, 9216, '#ebdec1', 0, 0);	

	//Radovis
	this.Items[63]=new this.sMapSet("10RD",22.4083139,41.594489,22.5273806,41.680819,3072,3072,"#ebdec1",0,0);
	this.Items[64]=new this.sMapSet("5RD",22.4083139,41.594489,22.5273806,41.680819,9216,9216,"#ebdec1",0,0);

	//Feni
	this.Items[65]=new this.sMapSet("10FN",21.964716,41.154485,22.008263,41.186653,2048,2048,"#ebdec1",0,0);
	this.Items[66] = new this.sMapSet("5FN", 21.961813, 41.151948, 22.007016, 41.151561, 3584, 3584, "#ebdec1", 0, 0);

	//Kocani
	this.Items[67] = new this.sMapSet("10KN", 22.353522, 41.871358, 22.4730417, 41.957736, 3072, 3072, "#ebdec1", 0, 0);
	this.Items[68] = new this.sMapSet("5KN", 22.353522, 41.871358, 22.4730417, 41.957736, 9216, 9216, "#ebdec1", 0, 0);

	//Berovo
	this.Items[69] = new this.sMapSet("10BR", 22.795542, 41.664019, 22.915244, 41.749933, 3072, 3072, "#ebdec1", 0, 0);
	this.Items[70] = new this.sMapSet("5BR", 22.795542, 41.664019, 22.915244, 41.749933, 9216, 9216, "#ebdec1", 0, 0);

	//Sveti Nikole
	this.Items[71] = new this.sMapSet("10SN", 21.883661, 41.822458, 22.002464, 41.909331, 3072, 3072, "#ebdec1", 0, 0);
	this.Items[72] = new this.sMapSet("5SN", 21.883661, 41.822458, 22.002464, 41.909331, 9216, 9216, "#ebdec1", 0, 0);

	//Pehcevo
	this.Items[73] = new this.sMapSet("10PH", 22.828092, 41.719978, 22.947942, 41.805856, 3072, 3072, "#ebdec1", 0, 0);
	this.Items[74] = new this.sMapSet("5PH", 22.828092, 41.719978, 22.947942, 41.805856, 9216, 9216, "#ebdec1", 0, 0);
	
	this.SetCountry = function(lat){
		if (lat > 42.176228) {
			// Kosovo
			this.Items[1] = this.ItemsKS[1]
			this.Items[2] = this.ItemsKS[2]
			this.Items[3] = this.ItemsKS[3]
			this.Items[4] = this.ItemsKS[4]
			//CurrentMapSet = 'KO'
			//alert('KO')
			
		} else {
			//Makedonija
			this.Items[1] = this.ItemsMK[1]
			this.Items[2] = this.ItemsMK[2]				
			this.Items[3] = this.ItemsMK[3]
			//this.Items[4] = this.ItemsMK[4]
			//CurrentMapSet = 'MK'	
			//alert('MK')
		}
		
	}
	
	this.getNewarestCity1 = function (lon, lat) {
	    var minD = 99999999;
	    var city = -1;
	    for (var i = 0; i <= 33; i++) {
	        var lon1 = this.Citis[i].cLon;
	        var lat1 = this.Citis[i].cLat;
	        var dis = this.getDistance(lon, lat, lon1, lat1);
	        if (dis < minD) {
	            //alert("dis = " + dis + "   i = " + i + "   lon1=" + lon1 + "   lat1=" + lat1);
	            minD = dis;
	            city = i;
	        }
	    }
		
		

		if(city==2 && minD>15000) city=-1
		if(city!=2 && minD>7000) city=-1
		
		if (city>-1) {
			this.Items[4] = this.Items[this.Citis[city].cZoom5]
			this.Items[5] = this.Items[this.Citis[city].cZoom6]	
			return city
		} else {
			return -1	
		}
	    //return this.Citis[city].cReg;
	};


	this.getNewarestCity = function (lon, lat) {
	    var minD = 99999999;
	    var city = -1;
	    for (var i = 0; i <= 33; i++) {
	        var lon1 = this.Citis[i].cLon;
	        var lat1 = this.Citis[i].cLat;
	        var dis = this.getDistance(lon, lat, lon1, lat1);
	        if (dis < minD) {
	            //alert("dis = " + dis + "   i = " + i + "   lon1=" + lon1 + "   lat1=" + lat1);
	            minD = dis;
	            city = i;
	        }
	    }
	    
	    //return this.Citis[city].cName
		for (var i=7;i<=74; i++) {
	        if ('5' + this.Citis[city].cReg == this.Items[i].ZoomLevel) { this.Items[6] = this.Items[i] };
	        if ('10' + this.Citis[city].cReg == this.Items[i].ZoomLevel) { this.Items[5] = this.Items[i] };
	    }
	    //alert(this.Items[5].ZoomLevel + "   " + this.Items[5].pointAX);
	};
	
	this.getDistance = function (lon1, lat1, lon2, lat2){
		var dtor = 57.295800;
		if ((lat1 == lat2) && (lon1==lon2)) {return 0.1};
		//if ((lat1 == lat2) && ((lon1-lon2)<0.0001)) {return 0.2};
		//if ((lon1 == lon2) && ((lat1-lat2)<0.0001)) {return 0.3};
		var vKm  = (6371.0 * Math.acos(Math.sin(lat1/dtor) * Math.sin(lat2/dtor) + Math.cos(lat1/dtor) * Math.cos(lat2/dtor) * Math.cos(lon2/dtor - lon1/dtor)));	
		return vKm*1000.0;
	};

	this.LonLat2XY = function (Lon, Lat, z) {

	    var coo = new Coordinates();
	    var uu = new Array(2)
	    uu = coo.LLtoUTM(parseFloat(Lon), parseFloat(Lat))

	    var nLon, nLat
	    nLon = uu[0]; nLat = uu[1]
	    

	    var pointAX, pointAY
	    var pointBX, pointBY

	    uu = coo.LLtoUTM(parseFloat(this.Items[z].pointAX), parseFloat(this.Items[z].pointAY))
	    pointAX = uu[0]; pointAY = uu[1];


	    uu = coo.LLtoUTM(parseFloat(this.Items[z].pointBX), parseFloat(this.Items[z].pointBY))
	    pointBX = uu[0]; pointBY = uu[1];
	    var x1 = nLon - pointAX;
	    x1 = x1 * (this.Items[z].widthPx / (pointBX - pointAX));

	    var y1 = nLat - pointAY;
	    y1 = y1 * (this.Items[z].heightPx / (pointBY - pointAY));
	    //alert(x1 + "   " + y1);
	    uu[0] = x1
	    uu[1] = y1
	    return uu
	}
	
	this.XY2LonLat = function(pX, pY, z){
		var coo = new Coordinates();
		var uu = new Array(2)
		
		var pointAX, pointAY
		var pointBX, pointBY
		
		uu = coo.LLtoUTM(this.Items[z].pointAX, this.Items[z].pointAY)
		pointAX = uu[0]; pointAY=uu[1];
		
		uu = coo.LLtoUTM(this.Items[z].pointBX, this.Items[z].pointBY)
		pointBX = uu[0]; pointBY=uu[1];		

		var lon = pX * ((pointBX-pointAX)/this.Items[z].widthPx);
		lon = lon + pointAX;

		var lat = pY * ((pointBY-pointAY)/this.Items[z].heightPx);
		lat = lat + pointAY;
		uu = coo.UTMtoLL(lon,lat)
		
		return uu;
	}
	
	this.Lon2X = function(Lon, z){
		var l = Lon - this.Items[z].pointAX;
		l = l * (this.Items[z].widthPx / (this.Items[z].pointBX - this.Items[z].pointAX));
		return l + this.Items[z].facX;
	};
	
	this.Lat2Y = function(Lat, z){
	    var l = Lat - this.Items[z].pointAY;
	    l = l * (this.Items[z].heightPx / (this.Items[z].pointBY - this.Items[z].pointAY));
	    return l + this.Items[z].facY;
	};
	this.X2Lon = function (px, z){
	    px = px - this.Items[z].facX;
	    var l = px * ((this.Items[z].pointBX - this.Items[z].pointAX) / this.Items[z].widthPx);
	    return (l + this.Items[z].pointAX);
	};
	this.Y2Lat = function(py, z){
	    py = py - this.Items[z].facY;
	    var l = py * ((this.Items[z].pointBY - this.Items[z].pointAY) / this.Items[z].heightPx);
	    return (l + this.Items[z].pointAY);
	};
	
};

function gnGraphic(type, points, bColor, fColor, width){
    this.type = type
    this.points = points
    this.bColor = bColor
    this.fColor = fColor   
    this.width = width
	this.element = null
	this.id = ''
	this.path = ''
	this.height = 0
	this.paddingLeft = 0
	this.paddingTop = 0
	
	
}




function gnMarker(ImagePath, title, lon, lat, width, height, visible, html, tag, label, color){
	this.ImagePath = ImagePath;
	this.title = title;
	this.lat = lat;
	this.lon = lon;
	this.width = width;
	this.height = height;
	this.visible = visible;
	this.html = html;
	this.tag = tag;
	this.X = 0
	this.Y = 0
	this.label = label;
	this.color = color;
	this.GoogleId = ''
	this.ImageX = 0
	this.ImageY = 0
	this.gMarker = null
	this.alarmid = 0
	this.Grid = 0
	

	this.setAlarmID = function(aid){
		this.alarmid = aid
	}
	this.SetgMarker = function(gm){
		this.gMarker = gm
	}
	this.SetImageXY = function(x,y) {
		this.ImageX = x
		this.ImageY = y
		
	}
	this.SetGoogleID = function (str) {
		this.GoogleId = str
	}

	this.setLL = function (lon, lat){
		this.lat = lat;
		this.lon = lon;		
	};

	this.getX = function (zoom) {
	    //var ms = new gnMapsSet;
	    //return ms.Lon2X(this.lon, zoom);
	    var MapSet = new Object();
	    MapSet = m.getCenterMap();
	    var ms = new gnMapsSet();
	    //alert(parseFloat(this.lon) + "  " + parseFloat(this.lat))
	    ms.getNewarestCity(parseFloat(MapSet[0]), parseFloat(MapSet[1]))
	    if (parseFloat(MapSet[1]) > 42.176228)
        {
            if ((zoom == 0) || (zoom == 1) || (zoom == 2) || (zoom == 3) || (zoom == 4))
            {
		        // Kosovo
		        ms.Items[1] = ms.ItemsKS[1]
		        ms.Items[2] = ms.ItemsKS[2]
		        ms.Items[3] = ms.ItemsKS[3]
		        ms.Items[4] = ms.ItemsKS[4]
            }
		} else
        {
		    if ((zoom == 0) || (zoom == 1) || (zoom == 2) || (zoom == 3) || (zoom == 4))
            {
		        //Makedonija
		        ms.Items[1] = ms.ItemsMK[0]
		        ms.Items[2] = ms.ItemsMK[1]
		        ms.Items[3] = ms.ItemsMK[2]
		        ms.Items[4] = ms.ItemsMK[3]
		    }
		}
		
	    var uu1 = new Array(2)
	    uu1 = ms.LonLat2XY(parseFloat(this.lon), parseFloat(this.lat), zoom)
	    //alert(this.lon+' = '+uu1[0]+'        '+this.lat+' = '+uu1[1]+ '       '+zoom)
	    return uu1[0]
	};

	this.getY = function(zoom){
		//var ms = new gnMapsSet;
		//return ms.Lat2Y(this.lat, zoom);

	    var MapSet = new Object();
	    MapSet = m.getCenterMap();

		var ms = new gnMapsSet();
		ms.getNewarestCity(parseFloat(MapSet[0]), parseFloat(MapSet[1]))

		if (parseFloat(MapSet[1]) > 42.176228) {
		    if ((zoom == 0) || (zoom == 1) || (zoom == 2) || (zoom == 3) || (zoom == 4)) {
		        // Kosovo
		        ms.Items[1] = ms.ItemsKS[1]
		        ms.Items[2] = ms.ItemsKS[2]
		        ms.Items[3] = ms.ItemsKS[3]
		        ms.Items[4] = ms.ItemsKS[4]
		    }
		} else {
		    if ((zoom == 0) || (zoom == 1) || (zoom == 2) || (zoom == 3) || (zoom == 4)) {
		        //Makedonija
		        ms.Items[1] = ms.ItemsMK[0]
		        ms.Items[2] = ms.ItemsMK[1]
		        ms.Items[3] = ms.ItemsMK[2]
		        ms.Items[4] = ms.ItemsMK[3]
		    }
		}

		var uu = new Array(2)
		uu = ms.LonLat2XY(parseFloat(this.lon),parseFloat(this.lat), zoom)
		return uu[1]

	}
}

function Coordinates(){

    var pi = 3.14159265358979;

    /* Ellipsoid model constants (actual values here are for WGS84) */
    var sm_a = 6378137.0;
    var sm_b = 6356752.314;
    var sm_EccSquared = 6.69437999013e-03;

    var UTMScaleFactor = 0.9996;


    /*
    * DegToRad
    *
    * Converts degrees to radians.
    *
    */
    function DegToRad (deg)
    {
        return (deg / 180.0 * pi);
    };




    /*
    * RadToDeg
    *
    * Converts radians to degrees.
    *
    */
    function RadToDeg (rad)
    {
        return (rad / pi * 180.0);
    };


    function ArcLengthOfMeridian (phi)
    {
        var alpha, beta, gamma, delta, epsilon, n;
        var result;

        /* Precalculate n */
        n = (sm_a - sm_b) / (sm_a + sm_b);

        /* Precalculate alpha */
        alpha = ((sm_a + sm_b) / 2.0)
           * (1.0 + (Math.pow (n, 2.0) / 4.0) + (Math.pow (n, 4.0) / 64.0));

        /* Precalculate beta */
        beta = (-3.0 * n / 2.0) + (9.0 * Math.pow (n, 3.0) / 16.0)
           + (-3.0 * Math.pow (n, 5.0) / 32.0);

        /* Precalculate gamma */
        gamma = (15.0 * Math.pow (n, 2.0) / 16.0)
            + (-15.0 * Math.pow (n, 4.0) / 32.0);
    
        /* Precalculate delta */
        delta = (-35.0 * Math.pow (n, 3.0) / 48.0)
            + (105.0 * Math.pow (n, 5.0) / 256.0);
    
        /* Precalculate epsilon */
        epsilon = (315.0 * Math.pow (n, 4.0) / 512.0);
    
    /* Now calculate the sum of the series and return */
    result = alpha
        * (phi + (beta * Math.sin (2.0 * phi))
            + (gamma * Math.sin (4.0 * phi))
            + (delta * Math.sin (6.0 * phi))
            + (epsilon * Math.sin (8.0 * phi)));

    return result;
    };



    function UTMCentralMeridian (zone)
    {
        var cmeridian;

        cmeridian = DegToRad (-183.0 + (zone * 6.0));
    
        return cmeridian;
    };



    function FootpointLatitude (y)
    {
        var y_, alpha_, beta_, gamma_, delta_, epsilon_, n;
        var result;
        
        /* Precalculate n (Eq. 10.18) */
        n = (sm_a - sm_b) / (sm_a + sm_b);
        	
        /* Precalculate alpha_ (Eq. 10.22) */
        /* (Same as alpha in Eq. 10.17) */
        alpha_ = ((sm_a + sm_b) / 2.0)
            * (1 + (Math.pow (n, 2.0) / 4) + (Math.pow (n, 4.0) / 64));
        
        /* Precalculate y_ (Eq. 10.23) */
        y_ = y / alpha_;
        
        /* Precalculate beta_ (Eq. 10.22) */
        beta_ = (3.0 * n / 2.0) + (-27.0 * Math.pow (n, 3.0) / 32.0)
            + (269.0 * Math.pow (n, 5.0) / 512.0);
        
        /* Precalculate gamma_ (Eq. 10.22) */
        gamma_ = (21.0 * Math.pow (n, 2.0) / 16.0)
            + (-55.0 * Math.pow (n, 4.0) / 32.0);
        	
        /* Precalculate delta_ (Eq. 10.22) */
        delta_ = (151.0 * Math.pow (n, 3.0) / 96.0)
            + (-417.0 * Math.pow (n, 5.0) / 128.0);
        	
        /* Precalculate epsilon_ (Eq. 10.22) */
        epsilon_ = (1097.0 * Math.pow (n, 4.0) / 512.0);
        	
        /* Now calculate the sum of the series (Eq. 10.21) */
        result = y_ + (beta_ * Math.sin (2.0 * y_))
            + (gamma_ * Math.sin (4.0 * y_))
            + (delta_ * Math.sin (6.0 * y_))
            + (epsilon_ * Math.sin (8.0 * y_));
        
        return result;
    };



    function MapLatLonToXY (phi, lambda, lambda0, xy)
    {
        var N, nu2, ep2, t, t2, l;
        var l3coef, l4coef, l5coef, l6coef, l7coef, l8coef;
        var tmp;

        /* Precalculate ep2 */
        ep2 = (Math.pow (sm_a, 2.0) - Math.pow (sm_b, 2.0)) / Math.pow (sm_b, 2.0);
    
        /* Precalculate nu2 */
        nu2 = ep2 * Math.pow (Math.cos (phi), 2.0);
    
        /* Precalculate N */
        N = Math.pow (sm_a, 2.0) / (sm_b * Math.sqrt (1 + nu2));
    
        /* Precalculate t */
        t = Math.tan (phi);
        t2 = t * t;
        tmp = (t2 * t2 * t2) - Math.pow (t, 6.0);

        /* Precalculate l */
        l = lambda - lambda0;
    
        /* Precalculate coefficients for l**n in the equations below
           so a normal human being can read the expressions for easting
           and northing
           -- l**1 and l**2 have coefficients of 1.0 */
        l3coef = 1.0 - t2 + nu2;
    
        l4coef = 5.0 - t2 + 9 * nu2 + 4.0 * (nu2 * nu2);
    
        l5coef = 5.0 - 18.0 * t2 + (t2 * t2) + 14.0 * nu2
            - 58.0 * t2 * nu2;
    
        l6coef = 61.0 - 58.0 * t2 + (t2 * t2) + 270.0 * nu2
            - 330.0 * t2 * nu2;
    
        l7coef = 61.0 - 479.0 * t2 + 179.0 * (t2 * t2) - (t2 * t2 * t2);
    
        l8coef = 1385.0 - 3111.0 * t2 + 543.0 * (t2 * t2) - (t2 * t2 * t2);
    
        /* Calculate easting (x) */
        xy[0] = N * Math.cos (phi) * l
            + (N / 6.0 * Math.pow (Math.cos (phi), 3.0) * l3coef * Math.pow (l, 3.0))
            + (N / 120.0 * Math.pow (Math.cos (phi), 5.0) * l5coef * Math.pow (l, 5.0))
            + (N / 5040.0 * Math.pow (Math.cos (phi), 7.0) * l7coef * Math.pow (l, 7.0));
    
        /* Calculate northing (y) */
        xy[1] = ArcLengthOfMeridian (phi)
            + (t / 2.0 * N * Math.pow (Math.cos (phi), 2.0) * Math.pow (l, 2.0))
            + (t / 24.0 * N * Math.pow (Math.cos (phi), 4.0) * l4coef * Math.pow (l, 4.0))
            + (t / 720.0 * N * Math.pow (Math.cos (phi), 6.0) * l6coef * Math.pow (l, 6.0))
            + (t / 40320.0 * N * Math.pow (Math.cos (phi), 8.0) * l8coef * Math.pow (l, 8.0));
    
        return;
    }
    
    
    function MapXYToLatLon (x, y, lambda0, philambda)
    {
        var phif, Nf, Nfpow, nuf2, ep2, tf, tf2, tf4, cf;
        var x1frac, x2frac, x3frac, x4frac, x5frac, x6frac, x7frac, x8frac;
        var x2poly, x3poly, x4poly, x5poly, x6poly, x7poly, x8poly;
    	
        /* Get the value of phif, the footpoint latitude. */
        phif = FootpointLatitude (y);
        	
        /* Precalculate ep2 */
        ep2 = (Math.pow (sm_a, 2.0) - Math.pow (sm_b, 2.0))
              / Math.pow (sm_b, 2.0);
        	
        /* Precalculate cos (phif) */
        cf = Math.cos (phif);
        	
        /* Precalculate nuf2 */
        nuf2 = ep2 * Math.pow (cf, 2.0);
        	
        /* Precalculate Nf and initialize Nfpow */
        Nf = Math.pow (sm_a, 2.0) / (sm_b * Math.sqrt (1 + nuf2));
        Nfpow = Nf;
        	
        /* Precalculate tf */
        tf = Math.tan (phif);
        tf2 = tf * tf;
        tf4 = tf2 * tf2;
        
        /* Precalculate fractional coefficients for x**n in the equations
           below to simplify the expressions for latitude and longitude. */
        x1frac = 1.0 / (Nfpow * cf);
        
        Nfpow *= Nf;   /* now equals Nf**2) */
        x2frac = tf / (2.0 * Nfpow);
        
        Nfpow *= Nf;   /* now equals Nf**3) */
        x3frac = 1.0 / (6.0 * Nfpow * cf);
        
        Nfpow *= Nf;   /* now equals Nf**4) */
        x4frac = tf / (24.0 * Nfpow);
        
        Nfpow *= Nf;   /* now equals Nf**5) */
        x5frac = 1.0 / (120.0 * Nfpow * cf);
        
        Nfpow *= Nf;   /* now equals Nf**6) */
        x6frac = tf / (720.0 * Nfpow);
        
        Nfpow *= Nf;   /* now equals Nf**7) */
        x7frac = 1.0 / (5040.0 * Nfpow * cf);
        
        Nfpow *= Nf;   /* now equals Nf**8) */
        x8frac = tf / (40320.0 * Nfpow);
        
        /* Precalculate polynomial coefficients for x**n.
           -- x**1 does not have a polynomial coefficient. */
        x2poly = -1.0 - nuf2;
        
        x3poly = -1.0 - 2 * tf2 - nuf2;
        
        x4poly = 5.0 + 3.0 * tf2 + 6.0 * nuf2 - 6.0 * tf2 * nuf2
        	- 3.0 * (nuf2 *nuf2) - 9.0 * tf2 * (nuf2 * nuf2);
        
        x5poly = 5.0 + 28.0 * tf2 + 24.0 * tf4 + 6.0 * nuf2 + 8.0 * tf2 * nuf2;
        
        x6poly = -61.0 - 90.0 * tf2 - 45.0 * tf4 - 107.0 * nuf2
        	+ 162.0 * tf2 * nuf2;
        
        x7poly = -61.0 - 662.0 * tf2 - 1320.0 * tf4 - 720.0 * (tf4 * tf2);
        
        x8poly = 1385.0 + 3633.0 * tf2 + 4095.0 * tf4 + 1575 * (tf4 * tf2);
        	
        /* Calculate latitude */
        philambda[0] = phif + x2frac * x2poly * (x * x)
        	+ x4frac * x4poly * Math.pow (x, 4.0)
        	+ x6frac * x6poly * Math.pow (x, 6.0)
        	+ x8frac * x8poly * Math.pow (x, 8.0);
        	
        /* Calculate longitude */
        philambda[1] = lambda0 + x1frac * x
        	+ x3frac * x3poly * Math.pow (x, 3.0)
        	+ x5frac * x5poly * Math.pow (x, 5.0)
        	+ x7frac * x7poly * Math.pow (x, 7.0);
        	
        return;
    }

	function getDistance (lon1, lat1, lon2, lat2){
		var dtor = 57.295800;
		if ((lat1 == lat2) && (lon1==lon2)) {return 0.0};
		//if ((lat1 == lat2) && ((lon1-lon2)<0.0001)) {return 0.2};
		//if ((lon1 == lon2) && ((lat1-lat2)<0.0001)) {return 0.3};
		var vKm  = (6371.0 * Math.acos(Math.sin(lat1/dtor) * Math.sin(lat2/dtor) + Math.cos(lat1/dtor) * Math.cos(lat2/dtor) * Math.cos(lon2/dtor - lon1/dtor)));	
		return vKm*1000.0;
	};

    function LatLonToUTMXY (lat, lon, zone, xy)
    {
        MapLatLonToXY (lat, lon, UTMCentralMeridian (zone), xy);

        /* Adjust easting and northing for UTM system. */
        xy[0] = xy[0] * UTMScaleFactor + 500000.0;
        xy[1] = xy[1] * UTMScaleFactor;
        if (xy[1] < 0.0)
            xy[1] = xy[1] + 10000000.0;

        return zone;
    }
    
    
    function UTMXYToLatLon (x, y, zone, southhemi, latlon)
    {
        var cmeridian;
        	
        x -= 500000.0;
        x /= UTMScaleFactor;
        	
        /* If in southern hemisphere, adjust y accordingly. */
        if (southhemi)
        y -= 10000000.0;
        		
        y /= UTMScaleFactor;
        
        cmeridian = UTMCentralMeridian (zone);
        MapXYToLatLon (x, y, cmeridian, latlon);
        	
        return;
    }


    this.LLtoUTM = function (lon, lat) {
        var xy = new Array(2);
        var zone;
        zone = Math.floor((lon + 180.0) / 6) + 1;
        
        LatLonToUTMXY(DegToRad(lat), DegToRad(lon), zone, xy);

        if (zone == 35) {
            var xy1 = new Array(2)
            LatLonToUTMXY(DegToRad(lat), DegToRad(23.999999), 34, xy1);
            var d = getDistance(23.999999, lat, lon, lat)
            xy1[0] = xy1[0] + d
            return xy1
        } else {
            return xy;
        }

    }

    this.UTMtoLL = function(x, y) {
        if (x > 739553.6813474776) {
            x = 739553.6813474776;
        }

        var latlon = new Array(2);
        var zone, southhemi;
        zone = 34;
        southhemi = false;
        UTMXYToLatLon(x, y, zone, southhemi, latlon);
        latlon[1] = RadToDeg(latlon[1]);
        latlon[0] = RadToDeg(latlon[0]);
        return latlon;

    }
    	
}