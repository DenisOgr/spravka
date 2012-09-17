<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">
    <xsl:output indent="yes"/>
  <xsl:include href="../../engine/xsl/templates.xsl"/>
  
    <xsl:template match="list_news">
        <news>
        <xsl:variable name="start">/admin/?section=<xsl:value-of select="section"/>&amp;</xsl:variable> 
          <xsl:variable name="img">../img/</xsl:variable>
        <xsl:if test="node">         
        <table>
            <xsl:for-each select="node">
              <xsl:variable name="image" select="image"/>
                <tr>
                  <td>
                        <xsl:choose>
                          <xsl:when test="$image>0">
                            <a href="{$start}image_item={id}">
                              <img src="{$img}iconis.gif" width="18" height="16" border="0"
                                title="Изменить/удалить изображение"/>
                            </a>
                          </xsl:when>
                          <xsl:otherwise>
                            <a href="{$start}image_item={id}">
                              <img src="{$img}iconno.gif" width="18" height="16" border="0"
                                title="Загрузить изображение"/>
                            </a>
                          </xsl:otherwise>
                        </xsl:choose>
                    </td>
                    <td>
                      <xsl:variable name="attribute">border="0"</xsl:variable>
                      <xsl:copy-of select="php:function('Files::show_image','news_image',string(id),string(image), string($attribute))"/>
                    </td>
                    <td>
                      <xsl:value-of select="date"/>
                      <br/>
                      <xsl:value-of select="title" disable-output-escaping="yes"/>
                      <br/>
                      <xsl:value-of select="anons" disable-output-escaping="yes"/>
                    </td>
                    <td>
                        <a href="{$start}edit_item={id}"> Редактировать </a>
                    </td>
                    <td>
                        <a href="{$start}delete_item={id}" onclick="return delete_confirm();">
                            Удалить </a>
                    </td>
                </tr>
                <xsl:choose>
                <xsl:when test="../image_item=id">
                  <tr>
                    <td colspan="3">
                    <!--form method="post"-->
                  
                  <xsl:call-template name="upload">
                    <xsl:with-param name="name" select="'news_image'"/>
                    <xsl:with-param name="id" select="id"/>
                    <xsl:with-param name="value" select="$image"/>
                    <xsl:with-param name="width" select="154"/>
                    <xsl:with-param name="height" select="107"/>
                  </xsl:call-template>
                  
                  <!--input type="submit" name="section_icon" value="Сохранить" class="submit"/>
                  </form-->
                    </td>
              </tr>
              </xsl:when>
                </xsl:choose>
            </xsl:for-each>
        </table>
        </xsl:if>
        <br/>
        <a href="{$start}add"> Добавить новость</a>
        </news>
    </xsl:template>
</xsl:stylesheet>
