<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>

    <xsl:template match="list_articles">
       <articles>
           <xsl:variable name="start">/admin/?section=<xsl:value-of select="section"/>&amp;</xsl:variable>        
        <xsl:if test="node">         
        <table>
            <xsl:for-each select="node">
                <tr>
                    <td>
                        <xsl:value-of select="title"/>
                    </td>
                    <td>
                        <a href="{$start}edit_item={id}"> Редактировать </a>
                    </td>
                    <td>
                        <a href="{$start}delete_item={id}" onclick="return delete_confirm();">
                            Удалить </a>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
        </xsl:if>
        <br/>
        <a href="{$start}add"> Создать статью </a>
       </articles> 
    </xsl:template>
</xsl:stylesheet>
