	<reference name="head">
		<block type="core/text" name="viewport.media">
			<action method="setText" ifconfig="meigee_unique_general/layout/responsiveness">
				<text><![CDATA[<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />]]></text>
			</action>
		</block>
		<action method="addJs"><script>meigee/jquery.min.js</script></action>
        <action method="addItem"><type>skin_js</type><name>js/jquery.easing.js</name><params/></action>
		<!--Removing items set in the page.xml we don't need since we're integrating the HTML 5 boilerplate-->
		<action method="removeItem"><type>skin_js</type><name>js/ie6.js</name><if>lt IE 7</if></action>
		<action method="removeItem"><type>js</type><name>lib/ds-sleight.js</name><params/><if>lt IE 7</if></action>
		<action method="removeItem"><type>css</type><name>css/print.css</name></action>
		<!--End "Removing items"-->
		<!--Adding js script for lt IE9-->
		<action method="addItem"><type>skin_js</type><name>js/script_ie.js</name><params/><if>lt IE 10</if></action>  
		<action method="addItem"><type>skin_js</type><name>js/html5.js</name><params/><if>lt IE 9</if></action>
		<action method="addItem"><type>skin_js</type><name>js/css3-mediaqueries.js</name><params/><if>lt IE 9</if></action>
		<action method="addItem"><type>skin_js</type><name>js/selectivizr-min.js</name><params/><if>lt IE 9</if></action>
		<!--<action method="addItem"><type>skin_js</type><name>js/dd_belatedpng.js</name><params/><if>lt IE 7</if></action>-->
        <!--Adding my own jQuery custom script-->
		<action method="addItem"><type>skin_js</type><name>js/jquery.selectbox-0.2.min.js</name><params/></action>
        <action method="addItem"><type>skin_js</type><name>js/script.js</name><params/></action>
		<action method="addItem"><type>skin_js</type><name>js/progressButton.js</name><params/></action>
		<action method="addItem"><type>skin_js</type><name>js/jquery.iosslider.min.js</name><params/></action>
		<action method="addItem" ifconfig="meigee_unique_bgslider/slideroptions/enabled"><type>skin_js</type><name>js/jquery.backstretch.min.js</name><params/></action>
		<!--Adding "To Top" functionality-->
		<action method="addItem" ifconfig="meigee_unique_general/otheroptions/totop"><type>skin_js</type><name>js/jquery.ui.totop.js</name><params/></action>
		<!--Grid-->
		<action method="addCss"><stylesheet helper="ThemeOptionsUnique/switchGrid" /></action>
		<!--Font Awesome-->
        <action method="addCss"><stylesheet>css/font-awesome.min.css</stylesheet><params/></action>
		<!--Retina Styles-->
        <action method="addCss" ifconfig="meigee_unique_general/retina/status"><stylesheet>css/retina.css</stylesheet><params/></action>
		<!--Skin-->
        <action method="addCss"><stylesheet>css/skin.css</stylesheet><params/></action>
		<action method="addItem"><type>skin_css</type><name>css/styles-ie-8.css</name><params/><if>IE 8</if></action>
        <action method="addCss"><stylesheet>css/custom.css</stylesheet><params/></action>
        <block type="core/template" name="bgslider" template="meigee/bgslider.phtml" />
		<block type="core/template" name="subheader" template="meigee/subheader.phtml" />
        <!--End "Adding items" -->
		<!-- Google Map -->
		<block type="core/text" name="google.map">
			<action method="setText" ifconfig="meigee_unique_general/contactmap/map">
				<text><![CDATA[<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>]]></text>
			</action>
		</block>
	</reference>
