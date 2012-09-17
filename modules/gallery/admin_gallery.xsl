<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>

  <xsl:template match="gallery">
    <xsl:variable name="section">?section=<xsl:value-of select="section"/></xsl:variable>
    <xsl:variable name="width"><xsl:value-of select="width"/></xsl:variable>
    <xsl:variable name="height"><xsl:value-of select="height"/></xsl:variable>
    <xsl:variable name="path"><xsl:value-of select="short_path"/></xsl:variable>
    <xsl:variable name="page"><xsl:value-of select="page"/></xsl:variable>
    <gallery>
      <table><tr><td>
      <xsl:for-each select="picture">
        <xsl:variable name="id">
          <xsl:value-of select="id"/>
        </xsl:variable>
        <xsl:variable name="text">
          <xsl:value-of select="text"/>
        </xsl:variable>
        <xsl:variable name="filename">
          <xsl:value-of select="../long_path"/>fg<xsl:value-of select="../section"/>_<xsl:value-of select="id"/><xsl:value-of select="extension"/>
        </xsl:variable>
        <xsl:variable name="picture"><xsl:value-of select="../short_path"/>fg<xsl:value-of select="../section"/>_<xsl:value-of select="id"/><xsl:value-of select="extension"/></xsl:variable>
        <div style="border: 1px dotted silver; margin: 1px; float: left; width: 250px; height: 268px">
        <div style="float: left; width: {$width}px; height: {$height}px; text-align: center;">

          <a href="{$picture}" TARGET="_blank">
            <img title="{$text}" src="{$filename}"></img></a>
        </div>
          <div>
            <center><a href="{$section}&amp;edit={$id}&amp;page={$page}">Правка</a>&#160;&#160;
              <a href="{$section}&amp;delete={$id}&amp;page={$page}" onclick="return delete_confirm();">Удалить </a></center>
          </div>
        </div>
      </xsl:for-each>
      </td></tr></table>


      <xsl:if test="add_form">
        <center>
          <xsl:value-of select="links" disable-output-escaping="yes"/>
        </center>
        <xsl:variable name="message"><xsl:value-of select="message"/></xsl:variable>
        <xsl:variable name="item_id"><xsl:value-of select="id"/></xsl:variable>
        <hr/>
        <h2>Добавить изображение</h2>
        <sys_messages/>
        <form enctype="multipart/form-data" method="POST" action="/admin/{$section}&amp;page={$page}">

        <xsl:variable name="filename"><xsl:value-of select="long_path"/>fg<xsl:value-of select="section"/>_<xsl:value-of select="id"/><xsl:value-of select="extension"/></xsl:variable>
        <xsl:if test="extension">
          <div>
            <img title="{$filename}" src="{$filename}"></img>
          </div>
        </xsl:if>

          <div class="newline">Изображение <span class="red">*</span>:
            <input name="userfile" type="file" value="Загрузить"/>
          </div>
          <br/>
          <div class="newline">Отображать в скроллере:
          <input type="checkbox" name="scroller">
          <xsl:if test="scroller=1">
          <xsl:attribute name="checked">checked</xsl:attribute>
          </xsl:if>
          </input>
          </div>
          <div class="newline">Подпись к рисунку:
            <input name="text" type="input" value="{$message}"/>
            <input name="id" type="hidden" value="{$item_id}"/>
          </div>

          <div  class="newline">
            <select multiple="multiple" size="20" name="visible[]">
              <xsl:for-each select="sec_vis/node">
                <option value="{id}">
                  <xsl:if test="id=//gallery/vis_item/sec">
                    <xsl:attribute name="selected">selected</xsl:attribute>
                  </xsl:if>
                  <xsl:call-template name="mites">
                    <xsl:with-param name="id" select="id"/>
                  </xsl:call-template>
                  <xsl:value-of select="name"/>
                </option>
              </xsl:for-each>
            </select>
          </div>

          <div class="newline">
          <input name="save" value="Сохранить" class="submit" type="submit"/>
            <input type="reset" value="Сбросить" class="submit" name="reset"></input>
          </div>
          </form>

      </xsl:if>
    </gallery>

  </xsl:template>

  <xsl:template name="mites">
    <xsl:param name="id"/>
    <xsl:param name="path"/>
    <xsl:choose>
      <xsl:when test="//gallery/sec_vis/node/id_parent[../id=$id]!='' ">
        <xsl:call-template name="mites">
          <xsl:with-param name="id" select="//gallery/sec_vis/node/id_parent[../id=$id]"/>
          <xsl:with-param name="path">&#160;&#160;&#160;<xsl:value-of select="$path"/></xsl:with-param>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$path" disable-output-escaping="yes"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
</xsl:stylesheet>
