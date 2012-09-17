<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>

    <xsl:template match="list_registration">
        <registration>
        <xsl:variable name="start">?section=<xsl:value-of select="section"/>&amp;</xsl:variable>        
        <xsl:if test="node">         
        <table>
            <xsl:for-each select="node">
                <tr>
                    <td>
                        <xsl:value-of select="date_format"/>
                    </td>
                    <td>
                        <xsl:value-of select="name"/>
                    </td>                    
                    <td>
                        <xsl:value-of select="phone"/>
                    </td>                    
                    <td>
                        <xsl:value-of select="service"/>
                    </td>                    
                    <td>
                        <a href="{$start}delete_item={id}" onclick="return delete_confirm();">
                            Удалить </a>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
        </xsl:if>
   
        </registration>
    </xsl:template>
</xsl:stylesheet>
