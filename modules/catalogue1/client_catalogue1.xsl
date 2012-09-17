<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>
    
    <xsl:template match="catalogue1">
        <xsl:if test="count!=''">
    <span class="tips" title="Статистика за год. Обнуляется в ночь с 31 декабря на 1 января">Количество просмотров:
    <xsl:value-of select="count" /></span>

<!-- javascript coding -->
<script>
// execute your scripts when the DOM is ready. this is a good habit
$(function() {



// select all desired input fields and attach tooltips to them
$(".tips").tooltip({

  // place tooltip on the right edge
  position: "center right",

  // a little tweaking of the position
  offset: [-2, 10],

  // use the built-in fadeIn/fadeOut effect
  effect: "fade",

  // custom opacity setting
  opacity: 0.7

});
});
</script></xsl:if>
<div style="clear:both;"/><br/>
      <xsl:if test="not(detail)">
      <xsl:value-of select="anons/text" disable-output-escaping="yes"/>
      </xsl:if>
      <xsl:variable name="section">
        <xsl:value-of select="section"/>
      </xsl:variable>
      
      <xsl:choose>      
        <xsl:when test="detail">
            <xsl:variable name="name">
              <xsl:value-of select="edit/name"/>
            </xsl:variable>
          <br/>
          <b><xsl:value-of select="detail/name" disable-output-escaping="yes"/></b><br/><br/>
            
          <xsl:value-of select="detail/text" disable-output-escaping="yes" /><br/>
            
            <!--xsl:if test="detail/price != 0">
              <xsl:value-of select="detail/price"/> руб.  <br/><br/>
              </xsl:if-->
            
            <xsl:for-each select="detail/picture">
              <xsl:variable name="pic_id"><xsl:value-of select="id"/></xsl:variable>
              <xsl:variable name="pic">/uploads/thumb/ct<xsl:value-of select="id_goods"/>_<xsl:value-of select="id"/>_<xsl:value-of select="version"/><xsl:value-of select="extension"/></xsl:variable>
              <xsl:variable name="large_pic">/uploads/ct<xsl:value-of select="id_goods"/>_<xsl:value-of select="id"/>_<xsl:value-of select="version"/><xsl:value-of select="extension"/></xsl:variable>
              <!--div style="margin: 1px; float: left; width: 150px; height: 150px; text-align: center;"-->
              <div id="tableImg" style="float:left; margin:5px;">
                <a href="{$large_pic}" TARGET="_blank"><img src="{$pic}" border="0"/></a> 
              </div>
            </xsl:for-each>
        </xsl:when>
        <xsl:when test="item">
            <xsl:for-each select="item">
                <xsl:variable name="id"><xsl:value-of select="id"/></xsl:variable>
                <xsl:variable name="picture">/uploads/thumb/ct<xsl:value-of select="id"/>_<xsl:value-of select="picture_id"/>_<xsl:value-of select="picture_ver"/><xsl:value-of select="picture_ext"/></xsl:variable>
                <xsl:variable name="large_picture">/uploads/ct<xsl:value-of select="id"/>_<xsl:value-of select="picture_id"/>_<xsl:value-of select="picture_ver"/><xsl:value-of select="picture_ext"/></xsl:variable>
              <div style="float:left; margin:5px; height:150px; width:150px;">
                <div>
              <xsl:if test="picture_ver/text()!=''">
                    <a href="?section={$section}&amp;item={$id}"><img src="{$picture}" border="0"></img></a>
              </xsl:if>
                </div>
                 <div style="text-align:center;">
                   <a href="?section={$section}&amp;item={$id}">
                  <strong><xsl:value-of select="name" disable-output-escaping="yes"/></strong>
                   </a>
                 </div>
              </div>              
            </xsl:for-each>
        </xsl:when>
        <xsl:otherwise/>
      </xsl:choose>
      
     
      <center>
        <xsl:value-of select="links" disable-output-escaping="yes"/>
      </center> 
      <div style="clear:both"/>

      </xsl:template>
</xsl:stylesheet>
