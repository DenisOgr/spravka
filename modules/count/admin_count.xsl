<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	version="1.0">
	<xsl:output indent="yes" />

  <xsl:template match="stat">
  <count><xsl:apply-templates /></count>
  </xsl:template> 

	<xsl:template match="catalogue">
    <xsl:for-each select="node">
    <xsl:if test="name!=''">
      <div class="sections">
        <xsl:value-of select="name" />
        <span style="float:right;">
          <xsl:value-of select="count" />
        </span>
      </div>
    </xsl:if>
    </xsl:for-each>
	</xsl:template> 

	<xsl:template match="item/node">
     <xsl:for-each select="node">
      <div class="sections">
        <xsl:value-of select="name" />
        <span style="float:right;">
          <xsl:value-of select="count" />
        </span>
      </div>
    </xsl:for-each>
<!-- 		<xsl:choose> <xsl:when test="@id=0"> <ul id="tree"> <xsl:apply-templates 
			select="node" /> </ul> </xsl:when> <xsl:otherwise> <li class="sort" id="{id}" 
			alt="{name}"> <div class="sections"> <xsl:value-of select="name" /> <span 
			style="float:right"> <xsl:value-of select="count" /> </span> </div> <xsl:variable 
			name="id" select="id"/> <xsl:variable name="module" select="module"/> <xsl:for-each 
			select="//catalogue/node"> <xsl:if test="section=$id and name!=''"> <div 
			class="sections tree"> <xsl:value-of select="name" /> <span style="float:right"> 
			<xsl:value-of select="count" /> </span> </div> </xsl:if> </xsl:for-each> 
			<xsl:apply-templates select="node" /> </li> </xsl:otherwise> </xsl:choose> -->
	</xsl:template>

</xsl:stylesheet>
