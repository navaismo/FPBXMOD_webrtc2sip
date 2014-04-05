<?php
//Check if user is "logged in"
if (!defined('FREEPBX_IS_AUTH')) { 
	die('No direct script access allowed'); 
}
?>
<?php

if (isset($_POST['start_button']))
    {
         exec('screen -dmS wrtc /usr/local/sbin/webrtc2sip --config=/usr/local/sbin/config.xml');
    }

if (isset($_POST['stop_button']))
    {
         exec('killall webrtc2sip');
    }

if(isset($_POST['button'])){
        $pinfo=$_POST['info']; 
        $ptr1=$_POST['tr1']; 
        $ptr2=$_POST['tr2']; 
        $ptr3=$_POST['tr3'];
	$prel=$_POST['rel'] ;
	$prtps=$_POST['rtps'];
	$pmediac=$_POST['mediac'];
	$pvjb=$_POST['vjb'];
	$pvsize=$_POST['vsize'];
	$pbuffs=$_POST['buffs'];
	$pavpf=$_POST['avpf'];
	$psrtpm=$_POST['srtpm'];
	$psrtpt=$_POST['srtpt'];
	$pdtmf=$_POST['dtmf'];
	$pcodecs=$_POST['codecs'];
	$popus=$_POST['opus'];
	$pns=$_POST['ns'];
	$pns2=$_POST['ns2'];
	$pssl=$_POST['ssl'];
	
	//erase the file	
	file_put_contents("/usr/local/sbin/config.xml", "");
	
	//create the new XML
	$fp = fopen("/usr/local/sbin/config.xml", "w");
	fputs($fp, "<?xml version='1.0' encoding='utf-8' ?>");
	fputs($fp, "\n");
	fputs($fp, "<!-- Please check the technical guide (http://webrtc2sip.org/technical-guide-1.0.pdf) for more information on how to adjust this file -->");
	fputs($fp, "\n");
	fputs($fp, "<config>");
	fputs($fp, "\n");
	fputs($fp, "	<debug-level>".$pinfo."</debug-level>");
	fputs($fp, "\n");
	fputs($fp, "	<transport id='1'>".$ptr1."</transport>");
	fputs($fp, "\n");
	fputs($fp, "	<transport id='2'>".$ptr2."</transport>");
	fputs($fp, "\n");
	fputs($fp, "	<transport id='3'>".$ptr3."</transport>");
	fputs($fp, "\n");
	fputs($fp, "	<enable-media-coder>".$pmediac."</enable-media-coder>");
	fputs($fp, "\n");
	fputs($fp, "	<enable-100rel>".$prel."</enable-100rel>");
	fputs($fp, "\n");
	fputs($fp, "	<enable-videojb>".$pvjb."</enable-videojb>");
	fputs($fp, "\n");
	fputs($fp, "	<video-size-pref>".$pvsize."</video-size-pref>");
	fputs($fp, "\n");
	fputs($fp, "	<rtp-buffsize>".$pbuffs."</rtp-buffsize>");
	fputs($fp, "\n");
	fputs($fp, "	<avpf-tail-length>".$pavpf."</avpf-tail-length>");
	fputs($fp, "\n");
	
	if ( $psrtpm == 'disabled'){
		fputs($fp, "	<!--<srtp-mode>".$psrtpm."</srtp-mode>");
		fputs($fp, "\n");
		fputs($fp, "	<srtp-type>".$psrtpt."</srtp-type>-->");
		fputs($fp, "\n");
	}else{
		fputs($fp, "	<srtp-mode>".$psrtpm."</srtp-mode>");
		fputs($fp, "\n");
		fputs($fp, "	<srtp-type>".$psrtpt."</srtp-type>");
		fputs($fp, "\n");
	}		
	fputs($fp, "	<dtmf-type>".$pdtmf."</dtmf-type>");
	fputs($fp, "\n");
	fputs($fp, "	<codecs>".$pcodecs."</codecs>");
	fputs($fp, "\n");
	fputs($fp, "	<codec-opus-maxrates>".$popus."</codec-opus-maxrates>");
	fputs($fp, "\n");
	fputs($fp, "	<nameserver id='1'>".$pns."</nameserver>");
	fputs($fp, "\n");
	fputs($fp, "	<nameserver id='2'>".$pns2."</nameserver>");
	fputs($fp, "\n");
	fputs($fp, "	<ssl-certificates>".$pssl."</ssl-certificates>");
	fputs($fp, "\n");
	fputs($fp, "</config>");
	fputs($fp, "\n");

	fclose($fp);
}

?>

<?php


$myfile = '/usr/local/sbin/config.xml';

if (file_exists($myfile)){
	//Load XML and set some config
	$xml = new DOMDocument('1.0', 'utf-8');
	$xml->validateOnParse = true;
	$xml->formatOutput = true;
	$xml->preserveWhiteSpace = false;
	$xml->load('/usr/local/sbin/config.xml');

	//Get item Element
	$element = $xml->getElementsByTagName('config')->item(0);

	//Load child elements
	$debug = $element->getElementsByTagName('debug-level')->item(0);
	$t1 = $element->getElementsByTagName('transport')->item(0);
	$t2 = $element->getElementsByTagName('transport')->item(1);
	$t3 = $element->getElementsByTagName('transport')->item(2);
	$ertps = $element->getElementsByTagName('enable-rtp-symetric')->item(0);
	$e100 = $element->getElementsByTagName('enable-100rel')->item(0);
	$emc = $element->getElementsByTagName('enable-media-coder')->item(0);
	$evjb = $element->getElementsByTagName('enable-videojb')->item(0);
	$vsize = $element->getElementsByTagName('video-size-pref')->item(0);
	$rtpbuff = $element->getElementsByTagName('rtp-buffsize')->item(0);
	$avpftl = $element->getElementsByTagName('avpf-tail-length')->item(0);
	$srtpmd = $element->getElementsByTagName('srtp-mode')->item(0);
	$srtpty = $element->getElementsByTagName('srtp-type')->item(0);
	$avpftl = $element->getElementsByTagName('avpf-tail-length')->item(0);
	$codecs = $element->getElementsByTagName('codecs')->item(0);
	$dtmft = $element->getElementsByTagName('dtmf-type')->item(0);
	$nameserver = $element->getElementsByTagName('nameserver')->item(0);
	$nameserver2 = $element->getElementsByTagName('nameserver')->item(1);
	$opust = $element->getElementsByTagName('codec-opus-maxrates')->item(0);
	$sslc = $element->getElementsByTagName('ssl-certificates')->item(0);

}else{
	echo "<br><div style='background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;font-family:arial;color:red;font-size:12px;text-align:center'>
		<b>
			The configuration file doesn not exist. You must install first the webrtc2sip media gateway: <a href='https://dl.dropboxusercontent.com/u/1277237/webrtc.sh'>Download Here the script for installing it.</a>
		</b>
	</div>";
}
?>
<!--/****************************** html/php code *************************************/-->
	<!--<div id="sysinfo-left" class='infobox ui-corner-all'>-->
	<!--<div>-->
		<h3>WebRTC2SIP Gateway Settings</h3>
		<form method="post" action="" id="hmm-idk">		
                <table  align=left>
			<tr>
				<td>
					<label for='info'>Debug Level</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Define the minimum debug-level to display.")?><br>
						<?php echo _("Format: debug-level-value.")?><br>
						<?php echo _("Debug-level-value = INFO | WARN | ERROR | FATAL")?>
					</span>
					</a>
				</td>
				<td>
					<select name='info' id='info' class="text ui-widget-content ui-corner-all">
						<option value='INFO' <?php if( $debug->textContent == 'INFO' ){ echo "selected='selected'"; } ?> >INFO</option>
						<option value='WARN' <?php if( $debug->textContent == 'WARN' ){ echo "selected='selected'"; } ?> >WARN</option>
						<option value='ERROR' <?php if( $debug->textContent == 'ERROR' ){ echo "selected='selected'"; } ?> >ERROR</option>
						<option value='FATAL' <?php if( $debug->textContent == 'FATAL' ){ echo "selected='selected'"; } ?> >FATAL</option>
					</select>
			</tr>

			<tr>
				<td>
					<label for='trasnport1'>Transport</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Each entry defines a protocol, local IP address and port to bind to.")?><br>
						<?php echo _("Format: proto-value;local-ip-value;local-port-value")?><br>
						<?php echo _("proto-value: udp | tcp | tls | ws | wss | c2c | c2cs")?><br><br>
						<?php echo _(" 'ws' protocol defines WebSocket and 'wss' the secure version. At least one WebSocket transport must be added to allow the web browser to connect to the server. 
								The other protocols (tcp, tls and udp) are used to forward the request from the web browser to
								the SIP-legacy network. 'C2c' and 'c2cs' are used for the click-to-call service and
								runs on top of HTTP or HTTPS protocols respectively.
								local-ip-value: Any valid IP address. Use star (*) to let the server choose the best
								local-ip-value:
								local IP address to bind to. Examples: udp;*;5060 or ws;*;5061 or wss;192.168.0.10;5062
								local-port-value: Any local free port to bind to. Use star (*) to let the server choose the best free port to bind to. Examples: udp;*;*, ws;*;*, wss;*;5062
								")?>

					</span>
					</a>
				</td>
				<td><input type='text' placeholder='udp;*;10060' name='tr1' id='tr1' class="text ui-widget-content ui-corner-all" value="<?php echo $t1->textContent; ?>" /></td>

			</tr>
			<tr>
				<td>
					<label for='trasnport2'>Transport</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Each entry defines a protocol, local IP address and port to bind to.")?><br>
						<?php echo _("Format: proto-value;local-ip-value;local-port-value")?><br>
						<?php echo _("proto-value: udp | tcp | tls | ws | wss | c2c | c2cs")?><br><br>
						<?php echo _(" 'ws' protocol defines WebSocket and 'wss' the secure version. At least one WebSocket transport must be added to allow the web browser to connect to the server. 
								The other protocols (tcp, tls and udp) are used to forward the request from the web browser to
								the SIP-legacy network. 'C2c' and 'c2cs' are used for the click-to-call service and
								runs on top of HTTP or HTTPS protocols respectively.
								local-ip-value: Any valid IP address. Use star (*) to let the server choose the best
								local-ip-value:
								local IP address to bind to. Examples: udp;*;5060 or ws;*;5061 or wss;192.168.0.10;5062
								local-port-value: Any local free port to bind to. Use star (*) to let the server choose the best free port to bind to. Examples: udp;*;*, ws;*;*, wss;*;5062
								")?>

					</span>
					</a>

				</td>
				<td><input type='text' placeholder='ws;*;10060' name='tr2' id='tr2' class='text ui-widget-content ui-corner-all' value="<?php echo $t2->textContent; ?>" /></td>
			</tr>
			<tr>
				<td>
					<label for='trasnport3'>Transport</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Each entry defines a protocol, local IP address and port to bind to.")?><br>
						<?php echo _("Format: proto-value;local-ip-value;local-port-value")?><br>
						<?php echo _("proto-value: udp | tcp | tls | ws | wss | c2c | c2cs")?><br><br>
						<?php echo _(" 'ws' protocol defines WebSocket and 'wss' the secure version. At least one WebSocket transport must be added to allow the web browser to connect to the server. 
								The other protocols (tcp, tls and udp) are used to forward the request from the web browser to
								the SIP-legacy network. 'C2c' and 'c2cs' are used for the click-to-call service and
								runs on top of HTTP or HTTPS protocols respectively.
								local-ip-value: Any valid IP address. Use star (*) to let the server choose the best
								local-ip-value:
								local IP address to bind to. Examples: udp;*;5060 or ws;*;5061 or wss;192.168.0.10;5062
								local-port-value: Any local free port to bind to. Use star (*) to let the server choose the best free port to bind to. Examples: udp;*;*, ws;*;*, wss;*;5062
								")?>

					</span>
					</a>

				</td>
				<td><input type='text' placeholder='wss;*;10062' name='tr3' id='tr3' class="text ui-widget-content ui-corner-all" value="<?php echo $t3->textContent; ?>" /></td>
			</tr>
			<tr>
				<td>
					<label for='info'>RTP Symetric</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: enable-rtp-symetric-value")?><br>
						<?php echo _("enable-rtp-symetric-value: yes | no")?><br><br>
						<?php echo _("This option is used to force symmetric RTP and RTCP streams to help NAT and firewall
								traversal. It only applies on remote RTP/RTCP as local stream is always symmetric. If
								both parties (remote and local) have successfully negotiated ICE candidates then, none
								will be forced to use symmetric RTP/RTCP.
								An RTP/RTCP stream is symmetric if the same port is used to send and receive packets.
								This helps for NAT and firewall traversal as the outgoing packets open a pinhole for the ongoing ones.
								")?>

					</span>
					</a>

				</td>
				<td>
					<select name='rtps' id='rtps' class="text ui-widget-content ui-corner-all">
						<option value='yes' <?php if( $ertps->textContent == 'yes' ){ echo "selected='selected'"; } ?> >Yes</option>
						<option value='no' <?php if( $ertps->textContent == 'no' ){ echo "selected='selected'"; } ?> >No</option>
					</select>
				
			</tr>
			<tr>
				<td>
					<label for='info'>Enable 100rel</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: enable-100rel-value")?><br>
						<?php echo _("enable-100rel-value: yes|no")?><br><br>
						<?php echo _("Indicates whether to enable SIP 100rel extension.

								")?>

					</span>
					</a>

				</td>
				<td>
					<select name='rel' id='rel' class="text ui-widget-content ui-corner-all" >
						<option value='yes' <?php if ( $e100->textContent == 'yes' ){ echo "selected='selected'";} ?> >Yes</option>
						<option value='no' <?php if ( $e100->textContent == 'no' ){ echo "selected='selected'";} ?> >No</option>
					</select>

			</tr>
			<tr>
				<td>
					<label for='info'>Enable Media Coder</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: enable-media-coder-value")?><br>
						<?php echo _("enable-media-coder-value: yes|no")?><br><br>
						<?php echo _("Indicates whether to enable the Media Coder module or not. This option requires the
								RTCWeb Breaker to be enabled at the web browser level. When the Media Coder is enabled
								the gateway acts as a b2bua and both audio and video streams are transcoded if the
								remote peers don’t share same codecs.
								")?>

					</span>
					</a>
					
				</td>
				<td>
					<select name='mediac' id='mediac' class="text ui-widget-content ui-corner-all">
						<option value='yes' <?php if ( $emc->textContent == 'yes' ){ echo "selected='selected'";} ?> >Yes</option>
						<option value='no' <?php if ( $emc->textContent == 'no' ){ echo "selected='selected'";} ?> >No</option>
					</select>

			</tr>
			<tr>
				<td>
					<label for='info'>Enable VideoJB</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: enable-videojb-value")?><br>
						<?php echo _("enable-videojb-value : yes | no")?><br><br>
						<?php echo _("
								This option is only useful if the RTCWeb Breaker module is enabled at the web browser
								side. Enabling video jitter buffer gives better quality and improve smoothness. No
								RTCP-NACK messages will be sent to request dropped RTP packets if this option is disabled.
								")?>

					</span>
					</a>
				</td>
				<td>
					<select name='vjb' id='vjb' class="text ui-widget-content ui-corner-all">
						<option value='yes' <?php if ( $evjb->textContent == 'yes' ){ echo "selected='selected'";} ?> >Yes</option>
						<option value='no' <?php if ( $evjb->textContent == 'no' ){ echo "selected='selected'";} ?> >No</option>
					</select>

			</tr>
			<tr>
				<td>
					<label for='info'>Video Size</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: video-size-pref-value")?><br>
						<?php echo _("video-size-pref-value: sqcif | qcif | qvga | cif | hvga | vga | 4cif | svga | 480p | 720p | 16cif | 1080p")?><br><br>
						<?php echo _("
								This option defines the preferred video size to negotiate with the peers. There is no
								guarantee that the exact size will be used: video size to use = Min (Preferred, Pro-
								Pro-posed);

								")?>

					</span>
					</a>



				</td>
				<td>
					<select name='vsize' id='vsize' class="text ui-widget-content ui-corner-all">
						<option value='sqcif' <?php if ( $vsize->textContent == 'sqcif' ){ echo "selected='selected'";} ?> >sqcif</option>
						<option value='qcif' <?php if ( $vsize->textContent == 'qcif' ){ echo "selected='selected'";} ?> >qcif</option>
						<option value='qvga' <?php if ( $vsize->textContent == 'qvga' ){ echo "selected='selected'";} ?> >qvga</option>
						<option value='cif' <?php if ( $vsize->textContent == 'cif' ){ echo "selected='selected'";} ?> >cif</option>
						<option value='hvga' <?php if ( $vsize->textContent == 'hvga' ){ echo "selected='selected'";} ?> >hvga</option>
						<option value='vga' <?php if ( $vsize->textContent == 'vga' ){ echo "selected='selected'";} ?> >vga</option>
						<option value='4cif <?php if ( $vsize->textContent == '4cif' ){ echo "selected='selected'";} ?> '>4cif</option>
						<option value='svga' <?php if ( $vsize->textContent == 'svga' ){ echo "selected='selected'";} ?> >svga</option>
						<option value='480p' <?php if ( $vsize->textContent == '480p' ){ echo "selected='selected'";} ?> >480p</option>
						<option value='720p' <?php if ( $vsize->textContent == '720p' ){ echo "selected='selected'";} ?> >720p</option>
						<option value='16cif' <?php if ( $vsize->textContent == '16cif' ){ echo "selected='selected'";} ?> >16cif</option>
						<option value='1080p' <?php if ( $vsize->textContent == '1080p' ){ echo "selected='selected'";} ?> >1080p</option>
					</select>

			</tr>
			<tr>
				<td>
					<label for='buffs'>Buffer Size</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: rtp-buffsize-value")?><br>
						<?php echo _("rtp-buffsize-value: Any positive 32 bits integer value. Recommended: 65535.")?><br><br>
						<?php echo _("
								Defines the internal buffer size to use for RTP sockets. The higher this value is, the
								lower will be the RTP packet loss. Please note that the maximum value depends on your
								system (e.g. 65535 on Windows). A very high value could introduce delay on video stream
								and it’s highly recommended to also enable videojb option.
								")?>

					</span>
					</a>


				</td>
				<td><input type='text' placeholder='65535' name='buffs' id='buffs' class="text ui-widget-content ui-corner-all" value="<?php echo $rtpbuff->textContent; ?>" /></td>
			</tr>
			<tr>
				<td>
					<label for='avpf'>AVPF tail Lenght</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: avpf-tail-length-min;avpf-tail-length-max")?><br>
						<?php echo _("avpf-tail-length-min: Any positive 32 bits integer. avpf-tail-length-max: Any positive 32 bits integer.")?><br><br>
						<?php echo _("
								Defines the minimum and maximum tail length used to honor RTCP-NACK requests. This
								option require the Media Breaker module to be enabled on the web browser size. The
								higher this value is, the better will be the video quality. The default length will be
								equal to the minimum value and it’s up to the server to increase this value depending
								on the number of unrecoverable packet loss. The final value will be at most equal to
								the maximum defined in the xml file. Unrecoverable packet loss occures when the b2bua
								receive an RTCP-NACK for a sequence number already removed (very common when network RTT is very high or bandwidth very low).
								")?>

					</span>
					</a>

				</td>
				<td><input type='text' placeholder='100;400' name='avpf' id='avpf' class="text ui-widget-content ui-corner-all" value="<?php echo $avpftl->textContent; ?>" /></td>

			</tr>
			<tr>
				<td>
					<label for='info'>SRTP Mode</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: srtp-mode-value")?><br>
						<?php echo _("srtp-mode-value: none | optional | mandatory")?><br><br>
						<?php echo _("
								Defines the SRTP mode to use for negotiation when the RTCWeb Breaker is enabled. Please
								note that only optional and mandatory modes will work when the call is to a WebRTC
								endpoint.
								Based on the mode, the SDP for the outgoing INVITEs will be formed like this:
								none: pofile = RTP/AVP ||| neither crypto lines or certificate fingerprints
								optional: profile = RTP/AVP ||| two crypto lines if <srtp-type /> includes
								‘SDES’ plus certificate fingerprints if <srtp-type /> include ‘DTLS’.
								mandatory: profile = RTP/SAVP if <srtp-type /> is eaqual to ‘SDES’ or
								UDP/TLS/RTP/SAVP if <srtp-type /> is equal to ‘DTLS’ ||| two crypto lines if <srtp-type
								/> is eaqual to ‘SDES’ or certificate fingerprints if <srtp-type /> is equal to ‘DTLS’

								")?>

					</span>
					</a>


				</td>
				<td>
					<select name='srtpm' id='srtpm' class="text ui-widget-content ui-corner-all">
						<option value='disabled' <?php if ( $srtpmd->textContent == 'disabled' ){ echo "selected='selected'";} ?> >-- Disable --</option>
						<option value='none' <?php if ( $srtpmd->textContent == 'none' ){ echo "selected='selected'";} ?> >None</option>
						<option value='optional' <?php if ( $srtpmd->textContent == 'optional' ){ echo "selected='selected'";} ?> >Optional</option>
						<option value='mandatory' <?php if ( $srtpmd->textContent == 'mandatory' ){ echo "selected='selected'";} ?> >Mandatory</option>
					</select>
					<script>


						$("#srtpm").change(function(){
							if ( $("#srtpm").val() == 'disabled'){
								$("#srtpt").attr('disabled',true);
								$("#ssl").attr('disabled',true);
								$("#srtpt").attr('value','');
								$("#ssl").attr('value','');
							}else{

								$("#srtpt").removeAttr('disabled');
								$("#ssl").removeAttr('disabled');
							}
						
						});	
					</script>

			</tr>
			<tr>
				<td>
					<label for='srtpt'>SRTP Type</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: srtp-type-value; (srtp-type-value)*")?><br>
						<?php echo _("srtp-type-value: sdes | dtls")?><br><br>
						<?php echo _("
								Defines the list of all supported SRTP types. Defining multiple values only make sense
								if the <srtp-mode /> value is optional which means we want to negotiate the best one.
								Please note that DTLS-SRTP requires valid TLS certificates and source code must be
								compiled with OpenSSL version 1.0.1 or later.

								")?>

					</span>
					</a>

				</td>
				<td>
					 <?php 
						if ( $srtpmd->textContent == '' ){
							echo "<input disabled type='text' placeholder='dtls;sdes' name='srtpt' id='srtpt' class='text ui-widget-content ui-corner-all' value='$srtpty->textContent'    />";
						}else{
							echo "<input type='text' placeholder='dtls;sdes' name='srtpt' id='srtpt' class='text ui-widget-content ui-corner-all' value='$srtpty->textContent' />";
						}						
					?>
				</td>

			</tr>
			<tr>
				<td>
					<label for='dtmf'>DTMF Type</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: dtmf-type-value")?><br>
						<?php echo _("dtmf-type-value: rfc4733 | rfc2833")?><br><br>
						<?php echo _("
								Defines the DTMF type to use when relaying the digits. Requires the RTCWeb Breaker to
								be enabled. rfc4733 will sends the DTMF digits using RTP packets while rfc2833 uses SIP
								INFO.
								
								")?>

					</span>
					</a>

				</td>
				<td>
					<select name='dtmf' id='dtfm' class="text ui-widget-content ui-corner-all">
						<option value='rfc4733' <?php if ( $dtmft->textContent == 'rfc4733' ){ echo "selected='selected'";} ?> >RFC4733</option>
						<option value='rfc2833' <?php if ( $dtmft->textContent == 'rfc2833' ){ echo "selected='selected'";} ?> >RFC2833</option>
					</select>

			</tr>
			<tr>
				<td>
					<label for='codecs'>Codecs</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: codec-name (; codec-name)*")?><br>
						<?php echo _("codec-name: opus|pcma|pcmu|amr-nb-be|amr-nb-oa|speex-nb|speex-wb|speex-uwb|g729|gsm|g722|ilbc|h264-bp|h264-mp|vp8|h263|h263+|theora|mp4v-es")?><br><br>
						<?php echo _("
								Defines the list of all supported codecs. Only G.711 is natively supported and all
								other codecs have to be enabled when building the Doubango IMS Framework source code.
								Each codec priority is equal to its position in the list. First codecs have highest
								priority.
								
								")?>

					</span>
					</a>

				</td>
				<td><input type='text' placeholder='pcma;pcmu;gsm;h264-bp;h264-mp;h263;h263+;h264' name='codecs' id='codecs' class='text ui-widget-content ui-corner-all' value='<?php echo $codecs->textContent; ?>' /></td>
			</tr>
			<tr>
				<td>
					<label for='opus'>Opus Max Rate</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: maxrate-playback-value; maxrate-capture-value")?><br>
						<?php echo _("maxrate-playback-value: 8000|12000|16000|24000|48000  maxrate-capture-value: 8000|12000|16000|24000|48000")?><br><br>
						<?php echo _("
								Defines the maximum playback and capture rates to negotiate. The final rates to use
								will be min(offer, answer). Default value = 48000 for both.
								The higher this value is, the better will be the voice quality. The bandwidth usage is
								proportional to the value. In short: high value = high bandwidth usage = good voice quality.
								
								")?>

					</span>
					</a>

				</td>
				<td><input type='text' placeholder='4800;4800' name='opus' id='opus' class="text ui-widget-content ui-corner-all" value="<?php echo $opust->textContent; ?>" /></td>

			</tr>
			<tr>
				<td>
					<label for='ns'>NameServer</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: nameserver-value")?><br>
						<?php echo _("nameserver-value: Any IPv4 or IPv6 address.")?><br><br>
						<?php echo _("
								Defines additional entries for DNS servers to use for SRV and NAPTR queries. Please
								note that this option is optional and should be used carefully.
								On Windows and OS X the server will automatically load these values using APIs provided
								by the OS. On linux, the values come from /etc/resolv.conf. The port must not be
								defined and the gateway will always use 53.
								
								")?>

					</span>
					</a>

				</td>
				<td><input type='text'  name='ns' id='ns' class="text ui-widget-content ui-corner-all" value="<?php echo $nameserver->textContent; ?>" /></td>

			</tr>
			<tr>
				<td>
					<label for='ns'>NameServer</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: nameserver-value")?><br>
						<?php echo _("nameserver-value: Any IPv4 or IPv6 address.")?><br><br>
						<?php echo _("
								Defines additional entries for DNS servers to use for SRV and NAPTR queries. Please
								note that this option is optional and should be used carefully.
								On Windows and OS X the server will automatically load these values using APIs provided
								by the OS. On linux, the values come from /etc/resolv.conf. The port must not be
								defined and the gateway will always use 53.
								
								")?>

					</span>
					</a>

				</td>
				<td><input type='text'  name='ns2' id='ns2' class="text ui-widget-content ui-corner-all" value="<?php echo $nameserver2->textContent; ?>" /></td>

			</tr>
			<tr>
				<td>
					<label for='ssl'>SSL Certs</label>
					<a href="#" class="info">
					<span>
						<?php echo _("Format: private-key-value;public-key-value;cacert-key-value; verify-value")?><br>
						<?php echo _("private-key-value: A valid path to a PEM file.
							      public-key-value: A valid path to a PEM file.
								cacert-key-value: A valid path to a certificate autority file. Should be equal to *.
								Verify-value: Yes | No. This additional option is only available since version 2.1.0.
								")?><br><br>
						<?php echo _("
								It indicates whether the connection should fail if the remote peer certificate are
								missing or do not match.This option only applies to TLS/SIP or WSS and is useless for
								DTLS-SRTP as certificates are required.
								
								")?>

					</span>
					</a>

				</td>
				<td>
					 <?php 
						if ( $srtpmd->textContent == '' ){
							echo "<input disabled type='text'  placeholder='private-key-value;public-key-value;cacert-key-value; verify-value' name='ssl' id='ssl' class='text ui-widget-content ui-corner-all' value='$sslc->textContent' />";
						}else{
							echo "<input type='text'  placeholder='private-key-value;public-key-value;cacert-key-value; verify-value' name='ssl' id='ssl' class='text ui-widget-content ui-corner-all' value='$sslc->textContent' />";
						}
					?>	
				</td>

			</tr>
			<tr></tr>
		</table><br>
		<div align=center>
			<br>
			<input name="button" type="submit" class="ui-state-error" value="Save Settings" id="save"/>

			<p style='Font-size: 10px;'>For more information about configuring webrtc2sip check <a href='http://webrtc2sip.org/technical-guide-1.0.pdf'>http://webrtc2sip.org/technical-guide-1.0.pdf</a></p>

			<?php
				$isopen = exec("ps -fea | grep -c '\/usr\/local\/sbin\/webrtc2sip'");
				
				if( $isopen == '2' ){
					echo "<br><br><br><h4>Status of the Gateway</h4>
					<div style='width:250px; height:40px; overflow:hidden; background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;font-family:arial;color:Green;font-size:12px;' class='ui-corner-all'>
						<b>
							The WebRTC2SIP Gateway Is Running 
						</b>
						<form method='post'>
							<br><input name='stop_button' type='submit'  value='Stop' />
						</form>
					</div>";
				}else{
					echo "<br><br><br><h4>Status of	the Gateway</h4>
					<div style='width:450px; height:60px; overflow:hidden; background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;font-family:arial;color:red;font-size:12px;' class='ui-corner-all'>
						<b>
							The WebRTC2SIP Gateway Is Not Running you must run the command:<br><br>
							screen -dmS wrtc /usr/local/sbin/webrtc2sip --config=/usr/local/sbin/config.xml 
						</b>
						<form method='post'>
							<br><input name='start_button' type='submit'  value='Start' />
						</form>

					</div>";
				}
					

			?> 

	
		</div>

		</form>

