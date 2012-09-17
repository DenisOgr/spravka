<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="channel">
        <div>
            <b>
                <xsl:value-of select="title"/>
            </b>
        </div>
        <xsl:for-each select="item[position()&lt;4]">
                <div>
                    <b>
                        <a>
                            <xsl:attribute name="href">
                                <xsl:value-of select="link"/>
                            </xsl:attribute>
                            <xsl:value-of select="pubDate"/>
                        </a>
                    </b><br/>
                    <b>
                        <a>
                            <xsl:attribute name="href">
                                <xsl:value-of select="link"/>
                            </xsl:attribute>
                            <xsl:value-of select="title"/>
                        </a>
                    </b><br/>
                    <xsl:value-of select="description"/>
                </div>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
