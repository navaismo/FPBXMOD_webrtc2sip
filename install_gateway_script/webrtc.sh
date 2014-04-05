###########################################################################
#									  #
#    This Script will install the Doubango's WebRTC2SIP media GateWay     #
# 			by Navaismo					  #
# 			navaismo@gmail.com				  #
# 			mreyesvera@digital-merge.com			  #
#									  #
# You can modify this script for your needs, just keep the original autor #
#									  #
###########################################################################
#!/bin/bash

	echo ""
	echo "**********************************"
	echo "*	This script will install   *"
	echo "*	WEBRTC2SIP & some extra    *"
	echo "*	Software		   *"
	echo "**********************************"



	cd /usr/src/
	mkdir webrtc_sources
	cd webrtc_sources
	
	yum -y install dialog

	URL="http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm"
	wget --progress=bar:force $URL 2>&1 | while read -d "%" X; do sed 's:^.*[^0-9]\([0-9]*\)$:\1:' <<< "$X"; done | dialog --backtitle "Digital-Merge's PBX" --gauge "Downloading Extra Repo" 10 100

	URL="http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.2-2.el6.rf.i686.rpm"
	wget --progress=bar:force $URL 2>&1 | while read -d "%" X; do sed 's:^.*[^0-9]\([0-9]*\)$:\1:' <<< "$X"; done | dialog --backtitle "Digital-Merge's PBX" --gauge "Downloading Extra Repo" 10 100

	sleep 1
	
	URL="http://rpms.famillecollet.com/enterprise/remi-release-6.rpm"
	wget --progress=bar:force $URL 2>&1 | while read -d "%" X; do sed 's:^.*[^0-9]\([0-9]*\)$:\1:' <<< "$X"; done | dialog --backtitle "Digital-Merge's PBX" --gauge "Downloading Extra Repo" 10 100

	rpm -Uvh remi-release-6*.rpm epel-release-6*.rpm rpmforge-release*.rpm &>/dev/null

	dialog --backtitle "Digital-Merge's PBX" --title "Installing Dependencies" --infobox "Please wait ...." 10 60
	yum install -y  gcc-c++ libxml2-devel openssl  openssl-devel  make  screen svn git php-xml libtool  gsm gsm-devel  speex speex-devel 
	echo "/usr/local/lib" >> /etc/ld.so.conf
	
	sleep 1


	git clone https://github.com/cisco/libsrtp/
	cd libsrtp
	CFLAGS="-fPIC" ./configure --enable-pic && make -j `getconf _NPROCESSORS_ONLN` && make runtest && make install
	cd ..

	##installing newest openssl
	wget http://www.openssl.org/source/openssl-1.0.1c.tar.gz
	tar -xvzf openssl-1.0.1c.tar.gz
	cd openssl-1.0.1c
	./config shared --prefix=/usr/local --openssldir=/usr/local/openssl && make -j `getconf _NPROCESSORS_ONLN` && make install
	cd ..

	##building YASM
	wget http://www.tortall.net/projects/yasm/releases/yasm-1.2.0.tar.gz
	tar -xvzf yasm-1.2.0.tar.gz
	cd yasm-1.2.0
	./configure && make -j `getconf _NPROCESSORS_ONLN` && make install
	cd ..

	##Building LIBVPX
	git clone http://git.chromium.org/webm/libvpx.git
	cd libvpx
	./configure --enable-realtime-only --enable-error-concealment --disable-examples --enable-vp8 --enable-pic --enable-shared --as=yasm
	make -j `getconf _NPROCESSORS_ONLN` && make install
	cd ..


	##Building x264
	wget ftp://ftp.videolan.org/pub/x264/snapshots/last_x264.tar.bz2
	tar -xvjf last_x264.tar.bz2
	# the output directory may be difference depending on the version and date
	cd x264*
	./configure --enable-static --enable-pic && make -j `getconf _NPROCESSORS_ONLN` && make install
	cd ..

	##building ffmpeg
	git clone git://source.ffmpeg.org/ffmpeg.git ffmpeg
	cd ffmpeg
	# grap a release branch
	git checkout n1.2
	./configure --extra-cflags="-fPIC" --extra-ldflags="-lpthread" --enable-pic --enable-memalign-hack --enable-pthreads --enable-shared --disable-static --disable-network --enable-pthreads --disable-ffmpeg --disable-ffplay --disable-ffserver --disable-ffprobe --enable-gpl --disable-debug
	make  -j `getconf _NPROCESSORS_ONLN` && make install
	cd ..


	
	dialog --backtitle "Digital-Merge's PBX" --title "Installing DOUBANGO Framework" --infobox "Please wait, this will take a while...." 10 60	
	svn co http://doubango.googlecode.com/svn/branches/2.0/doubango doubango
	cd doubango
	./autogen.sh
	./configure --with-ssl --with-srtp  --with-speex --with-speexdsp --enable-speexresampler --enable-speexjb --enable-speexdenoiser --with-gsm --with-ffmpeg --with-h264 --prefix=/usr/local
	make -j `getconf _NPROCESSORS_ONLN`
	make install
	ldconfig

	cd ..

	dialog --backtitle "Digital-Merge's PBX" --title "Installing WebRTC2SIP Media Gateway" --infobox "Please wait, this will take a while...." 10 60	
	##building webrtc2sip
	ldconfig
	svn co http://webrtc2sip.googlecode.com/svn/trunk/ webrtc2sip
	cd webrtc2sip
	./autogen.sh
	export PKG_CONFIG_PATH="$PKG_CONFIG_PATH:/usr/local/lib/pkgconfig"
	./configure --prefix=/usr/local/sbin
	make clean && make  -j `getconf _NPROCESSORS_ONLN` && make install
	cp -rf /usr/local/sbin/sbin/webrtc2sip /usr/local/sbin/
	cd ..
	
	cd /usr/local/sbin/
	URL="http://dl.dropbox.com/u/1277237/DMDistro/config.xml"
	#wget "$URL" 2>&1 | awk '/[.] +[0-9][0-9]?[0-9]?%/ { print substr($0,63,3) }' | dialog --backtitle "Digital-Merge's PBX" --gauge "Downloading Media Gatewy Config" 10 100
	wget --progress=bar:force $URL 2>&1 | while read -d "%" X; do sed 's:^.*[^0-9]\([0-9]*\)$:\1:' <<< "$X"; done | dialog --backtitle "Digital-Merge's PBX" --gauge "Downloading Media Gateway Config" 10 100
	chmod o+r config.xml
	chmod o+w config.xml
	sleep 1
	

	service httpd restart
	echo "screen -dmS wrtc /usr/local/sbin/webrtc2sip --config=/usr/local/sbin/config.xml >> /etc/rc.local"
	screen -dmS wrtc /usr/local/sbin/webrtc2sip --config=/usr/local/sbin/config.xml
	cd --


