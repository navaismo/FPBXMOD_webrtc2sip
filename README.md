###Changelog###
 -- 05/Jun/2013							  
 Added the Status of the Gateway to WebPage(webrtc2sip module)		  
 Added Start/Stop option to the WebPage(webrtc2sip module)		  
									  
 -- 01/Aug/2013							  
 Since Doubango Framework has changed the libvpx, X264, Yasm and openssl 
 are installed from source. 						  
									  
 -- 12/Aug/2013							  
 Added a RPM alternative to install the gateway                          
									 


**NOTES**: 
* Tested on Vanilla FreePBX install based on CentOS 6.3 32Bits	
* Tested on Vanilla FreePBX install based on Fedora 17  32Bits
* Tested on FreePBX-Distro FreePBX-3.211.63-8-i386-Full-1366661092	
	**REQUIRE AN ACTIVE INTERNET CONNECTION.**


###webrtc.sh Script###
1. INSTALLATION:

	run as root: `./webrtc.sh`

This script is used for install the Doubango's Framework & Webrtc2sip media 
gateway and all dependencies required. It will install Epel & Rpmforge Repo.

The location of the webrtc2sip binary is set to /usr/loca/sbin/.
In order to run the media gateway it install and run 'screen' program attaching 
it to a session called 'wrtc' if you want to check the debug or kill the gateway
use the next command:

	`screen -r wrtc`

* To stop the gateway just type `quit`.
* To kill the gateway and the screen session use CTRL+C.
* To exit the screen session without killing the gateway use: CTRL+A +D.


RPM alternative(faster than compile from sources):

1. `Download & untar https://dl.dropboxusercontent.com/u/1277237/RPM4WebRTC.tar.gz`
2. `yum install -y screen perl-WWW-Curl`
3.`rpm -ihv libtool-2.4.2-DMv1.i386.rpm`

	`rpm -ihv libsrtp-1.4.5-DMv1.i386.rpm`

	`rpm -ihv yasm-1.2.0-DMv1.i386.rpm`

	`rpm -ihv libvpx-1.2.0-DMv1.i386.rpm`

	`rpm -ihv x264-snapshot20130810.2245-DMv1.i386.rpm`

	`rpm -ihv ffmpeg-1.2-DMv1.i386.rpm`

	`rpm -ihv --force --no-deps doubango-2.0r985-DMv1.i386.rpm`

	`rpm -ihv webrtc2sip-2.5.1r114_CentOS-DMv1.i386`

**DO NOT INSTALL THE OPENSSL PACKAGE, IT WILL BREAK YOUR SSH AND OTHER STUFF ON CENTOS 6**

### Tarball webrtc2sip ###

INSTALLATION:
1. Open the FreePBX GUI in your Browser Go to ADMIN---->Module Admin.
2. Then choose Upload Module. Browse for the webrtc2sip-0.1.tar.gz tarball.
3. Navigate to Unsupported Modules select the New Module & install the Module.

This tarball provides a WebRTC2SIP Gateway Settings Module for FreePBX, it will create 
an entry in the Menu 'Admin' called WebRTC2SIP Settings. The tested configuration works 
without SRTP MODE. In order to enable read the guide and generate the certificates.

You can modify & save the preferences via web for the config.xml file.


Enjoy ;)

									  
by Navaismo					  
navaismo@gmail.com				  
mreyesvera@digital-merge.com			  
22/05/2013					  
									  
