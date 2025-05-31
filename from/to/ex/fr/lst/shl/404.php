
<html><head><title>404</title></head>
<body style="background-color: #000000; color: #00ff00">
	<script>
		function depart() {
			document.location.replace('http://cti.etoilediese.fr');
		}
		function curseur() {
			if (obaff.innerHTML.length > longueur) obaff.innerHTML = obaff.innerHTML.substring(0, obaff.innerHTML.length - 1);
			if (dercurs == ' ') {
				dercurs = "_";
			}
			else {
				dercurs = " ";
			}
			obaff.innerHTML += dercurs
			idcurs = setTimeout(curseur, 1000);
		}
		function scenario() {
			if (idcurs > 0) {
				clearTimeout(idcurs);
				idcurs = 0;
				if (obaff.innerHTML.length > longueur) obaff.innerHTML = obaff.innerHTML.substring(0, obaff.innerHTML.length - 1);
			}
			c = txtaff.charAt(rang);
			if (c == '<') {
				if (tempo > 0) {
					idcurs = setTimeout(curseur, 10);
					setTimeout(scenario, tempo * 1000);
					tempo = 0;
				}
				else {
					type = txtaff.substring(rang + 1, rang + 3);
					tempo = txtaff.charAt(rang + 3);
					rang += 5;
					scenario();
				}
			}
			else {

				// Caractere
				if (c == '\n') {
					obaff.innerHTML += "<br>";
				}
				else
				if (c == '|') {
					if (obaff.innerHTML.substring(obaff.innerHTML.length - 6, obaff.innerHTML.length) == '&nbsp;') {
						obaff.innerHTML = obaff.innerHTML.substring(0, obaff.innerHTML.length - 6);
					}
					else {
						obaff.innerHTML = obaff.innerHTML.substring(0, obaff.innerHTML.length - 1);
					}
				}
				else
				if (c == 'µ') {
					obaff.innerHTML = "";
				}
				else
				if (c == ' ') {
					obaff.innerHTML += '&nbsp;';
				}
				else {
					obaff.innerHTML += c;
				}
				rang++;
				longueur = obaff.innerHTML.length;


				// Tempo
				att = 0;
				if (type == 'HE') {
					att = Math.random() * 1000 + 200;
				}
				else
				if (type == 'LE') {
					att = 100;
				}
				else
				if (type == 'TL') {
					att = 600;
				}
				if (att > 500) idcurs = setTimeout(curseur, 10);
				if (rang < txtaff.length) setTimeout(scenario, att);
				else setTimeout(depart, 1000);
			}
		}
	</script>
	<div style="font-size: 96px; font-weight: bold; text-align: center">404</div><br><br>
	<div style="font-size: 24px; font-weight: bold; text-align: center">Page introuvable.</div><br><br>
	<div id="txt" style="font-size: 20px; font-family: sans-serif; text-align: left"></div>
	<script>
		var txtaff = "<AF3><AF2>Login: <HE3>kzvi|||evin<AF2>\nPassword: <HE1>*****||****|||******<LE2>\nLogging into account 'Kevin Leboulay' ...<LE2>µWelcome 3733t Master. Waiting for your orders my lord.\n\n[kevin@localhost ~]$ <HE1>ls -l<AF2>\nTotal 38\ndrwxr-xr-x kevin users      1024 Bureau\ndrwxr-xr-x kevin users      1024 Documents\ndrwxr-xr-x kevin users      1024 Images\ndrwxr-xr-x kevin users      1024 TipiaksAlbator\ndrwxr-xr-x kevin users     32768 TipiaksBoules\ndrwxr-xr-x kevin users      1024 Videos\n-rw-r--r-- kevin users        32 CleWifiMami_(hack_Lord_Kevin).txt\n-rw-r--r-- kevin users 710934528 Photoshop_cR4cK_iso_FR(By_WarlordZ).rar\n-rw-r--r-- kevin users        54 Serial_Photoshop_(hack_my_voisin).txt\n[kevin@localhost ~]$ <HE2>Phot<AF0>^C<AF1>\n[kevin@localhost ~]$ <HE0>chmod 777 ./Pho<AF1>toshop_cR4cK_iso_FR(By_WarlordZ).rar<AF1>\n[kevin@localhost ~]$ <HE0>./Phot<AF1>oshop_cR4cK_iso_FR(By_WarlordZ).rar<AF1>\nbash: ./Photoshop_cR4cK_iso_FR(By_WarlordZ).rar: not executable or bad file type\n[kevin@localhost ~]$ <HE0>rhaaaa<AF2>\nbash: rhaaaa : command not found\n[kevin@localhost ~]$ <HE1>su -<AF2>\nPassword: <HE0>*****|***<LE2>\n[root@localhost ~]# <HE1>hack da world !!!<LE0>\nHacking Da W0r1d in progress<TL0>..................<LE0>\nDone.";
		var rang = 0;
		var obaff = document.getElementById('txt');
		var type = "";
		var tempo = 0;
		var idcurs = 0;
		var dercurs = '-';
		var longueur = obaff.innerHTML.length;
		curseur();
		scenario();
	</script>
</body>
</html>
