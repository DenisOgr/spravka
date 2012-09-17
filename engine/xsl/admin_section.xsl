<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">
  <xsl:output encoding="utf-8" method="html" indent="yes" media-type="text/xhtml"/>

  <xsl:template match="section">
    <table id="section" width="332">
      <xsl:choose>
        <xsl:when test="not(//section/node/current_id)">
          <tr>
            <td colspan="2">
              <a href="/admin/?section_add">
                <img src="{$img}new.gif" border="0" title="Добавить раздел"/>
              </a>
              <xsl:if test="node/section_add='NULL'">
                <form method="post">
                  <input type="hidden" name="priority">
                    <xsl:attribute name="value">
                      <xsl:value-of select="count(node/node/node[2][text()=1])+1"/>
                    </xsl:attribute>
                  </input>
                  <input type="text" name="section_name" size="40"/>&#160; <input type="submit" name="section_add" value="Добавить" class="submit"/>
                </form>
              </xsl:if>
            </td>
          </tr>
        </xsl:when>
        <xsl:when test="node/node[node[1]=//section/node/current_id and node[2]&lt;3]">
          <tr>
            <td colspan="2">
              <xsl:choose>
                <xsl:when test="node/section_add=//section/node/current_id">
                  <form method="post">
                    <input type="hidden" name="priority">
                      <xsl:attribute name="value">
                        <xsl:value-of select="count(node/node/add/id_parent[text()=//section/node/current_id])+1"/>
                      </xsl:attribute>
                    </input>
                    <input type="text" name="section_name" size="40"/>&#160; <input type="submit" name="section_add" value="Добавить" class="submit"/>
                  </form>
                </xsl:when>
                <xsl:otherwise>
                  <a href="/admin/?section={//section/node/current_id}&amp;section_add={//section/node/current_id}">
                    <img src="{$img}new.gif" width="18" height="16" border="0" title="Добавить подраздел"/>
                  </a>
                </xsl:otherwise>
              </xsl:choose>
            </td>
          </tr>
        </xsl:when>
        <xsl:otherwise>
          <tr>
            <td colspan="2">
              <img src="{$img}new_hide.gif" width="18" height="16" border="0"/>
            </td>
          </tr>
        </xsl:otherwise>
      </xsl:choose>

      <xsl:for-each select="node/node[add/id_parent=//section/node/current_id or (not(//section/node/current_id) and node[position()=2]=1)]">
        <xsl:variable name="id" select="node[position()=1]"/>
        <xsl:variable name="level" select="node[position()=2]"/>
        <xsl:variable name="name" select="add/name"/>
        <xsl:variable name="alias" select="add/alias"/>
        <xsl:variable name="priority" select="add/priority"/>
        <xsl:variable name="parent" select="add/id_parent"/>
        <xsl:variable name="visible" select="add/visible"/>
        <xsl:variable name="static" select="add/static"/>
        <xsl:variable name="image" select="add/image"/>
        <xsl:variable name="show_img" select="add/show_img"/>
        <xsl:variable name="show_visibility" select="add/show_visibility"/>


        <xsl:variable name="section_parent">
          <xsl:if test="$parent!=''">section=<xsl:value-of select="$parent"/>&amp;</xsl:if>
        </xsl:variable>


        <tr>
          <td>
            <xsl:value-of select="$id"/>
          </td>
          <td>
            <xsl:choose>
              <xsl:when test="$level&lt;3">
                <xsl:value-of select="add/id_parent"/>
                <a href="?{$section_parent}section_add={$id}">
                  <img src="{$img}new.gif" width="18" height="16" border="0" title="Добавить подраздел"/>
                </a>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}new_hide.gif" width="18" height="16" border="0"/>
              </xsl:otherwise>
            </xsl:choose>

            <a href="?{$section_parent}section_edit={$id}">
              <img src="{$img}edit.gif" width="18" height="16" border="0" title="Редактировать название"/>
            </a>

            <xsl:choose>
              <xsl:when test="$static=0">
                <a href="/admin/?section_delete={$id}&amp;priority={$priority}&amp;parent={$parent}" onclick="return delete_confirm();">
                  <img src="{$img}delete.gif" width="18" height="16" border="0" title="Удалить"/>
                </a>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}delete_hide.gif" width="18" height="16" border="0"/>
              </xsl:otherwise>
            </xsl:choose>

            <xsl:choose>
              <xsl:when test="$show_visibility=1">
                <xsl:choose>
                  <xsl:when test="$visible=1">
                    <a href="/admin/?section={//section/node/current_id}&amp;section_hide={$id}">
                      <img src="{$img}show.gif" width="18" height="16" border="0" title="Раздел присутсвует в главном меню"/>
                    </a>
                  </xsl:when>
                  <xsl:otherwise>
                    <a href="/admin/?section={//section/node/current_id}&amp;section_show={$id}">
                      <img src="{$img}hide.gif" width="18" height="16" border="0" title="Раздел отсутсвует в главном меню"/>
                    </a>
                  </xsl:otherwise>
                </xsl:choose>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}spacer.gif" width="18" height="16" border="0"/>
              </xsl:otherwise>
            </xsl:choose>

            <xsl:choose>
              <xsl:when test="$level=1">
                <xsl:choose>
                  <xsl:when test="$show_img=1">
                    <xsl:choose>
                      <xsl:when test="$image>0">
                        <a href="/admin/?section={//section/node/current_id}&amp;section_image={$id}">
                          <img src="{$img}iconis.gif" width="18" height="16" border="0" title="Изменить/удалить изображение"/>
                        </a>
                      </xsl:when>
                      <xsl:otherwise>
                        <a href="/admin/?section={//section/node/current_id}&amp;section_image={$id}">
                          <img src="{$img}iconno.gif" width="18" height="16" border="0" title="Загрузить изображение"/>
                        </a>
                      </xsl:otherwise>
                    </xsl:choose>
                  </xsl:when>
                  <xsl:otherwise>
                    <img src="{$img}spacer.gif" width="18" height="16" border="0"/>
                  </xsl:otherwise>
                </xsl:choose>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}spacer.gif" width="18" height="16" border="0"/>

              </xsl:otherwise>
            </xsl:choose>


            <img src="{$img}spacer.gif" width="4" height="16" border="0"/>
            <xsl:choose>
              <xsl:when test="$priority!=1">
                <a>
                  <xsl:attribute name="href">?move_up=<xsl:value-of select="$id"/>&amp;priority=<xsl:value-of select="$priority"/><xsl:if test="$parent>0">&amp;parent=<xsl:value-of select="$parent"/></xsl:if>
                  </xsl:attribute>
                  <img src="{$img}up.gif" alt=""/>
                </a>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}spacer.gif" width="18" height="16" border="0"/>
              </xsl:otherwise>
            </xsl:choose>
            <img src="{$img}spacer.gif" width="4" height="16" border="0"/>
            <xsl:choose>
              <xsl:when test="$priority!=count(../node/node[2][text()=1]) and $level=1">
                <a>
                  <xsl:attribute name="href">?move_down=<xsl:value-of select="$id"/>&amp;priority=<xsl:value-of select="$priority"/><xsl:if test="$parent>0">&amp;parent=<xsl:value-of select="$parent"/></xsl:if>
                  </xsl:attribute>
                  <img src="{$img}down.gif" alt=""/>
                </a>
              </xsl:when>
              <xsl:when test="$level=2 and $priority!=count(../node/add/id_parent[text()=$parent])">
                <a>
                  <xsl:attribute name="href">?move_down=<xsl:value-of select="$id"/>&amp;priority=<xsl:value-of select="$priority"/><xsl:if test="$parent>0">&amp;parent=<xsl:value-of select="$parent"/></xsl:if>
                  </xsl:attribute>
                  <img src="{$img}down.gif" alt=""/>
                </a>
              </xsl:when>
              <xsl:when test="$level=3 and $priority!=count(../node/add/id_parent[text()=$parent])">
                <a>
                  <xsl:attribute name="href">?move_down=<xsl:value-of select="$id"/>&amp;priority=<xsl:value-of select="$priority"/><xsl:if test="$parent>0">&amp;parent=<xsl:value-of select="$parent"/></xsl:if>
                  </xsl:attribute>
                  <img src="{$img}down.gif" alt=""/>
                </a>
              </xsl:when>
              <xsl:otherwise>
                <img src="{$img}spacer.gif" width="18" height="16" border="0"/>
              </xsl:otherwise>
            </xsl:choose>

            <img src="{$img}spacer.gif" width="4" height="16" border="0"/>
          </td>
          <td>
            <xsl:attribute name="style">padding-left:<xsl:value-of select="$level*10"/>px; white-space: normal;</xsl:attribute>
            <a href="/admin/?section={$id}">
              <xsl:choose>
                <xsl:when test="$level=1">
                  <b>
                    <xsl:value-of select="$name"/>
                  </b>
                </xsl:when>
                <xsl:otherwise>
                  <xsl:value-of select="$name"/>

                </xsl:otherwise>
              </xsl:choose>
            </a>
            <xsl:choose>
              <xsl:when test="../section_add=$id">
                <form method="post">
                  <input type="hidden" name="priority">
                    <xsl:attribute name="value">
                      <xsl:value-of select="count(../node/add/id_parent[text()=$id])+1"/>
                    </xsl:attribute>
                  </input>
                  <input type="text" name="section_name" size="40"/>&#160; <input type="submit" name="section_add" value="Добавить" class="submit"/>
                </form>
              </xsl:when>
              <xsl:when test="../section_edit=$id">
                <form method="post">
                  Название&#160;<input type="text" name="section_name" value="{$name}" size="40"/><br/>
                  Алиас&#160;<input type="text" name="section_alias" value="{$alias}" size="40"/>
                  &#160; <input type="submit" name="section_edit" value="Cохранить" class="submit"/>
                  
                </form>
              </xsl:when>
              <xsl:when test="../section_image=$id">
                <!--form method="post"-->

                <xsl:call-template name="upload">
                  <xsl:with-param name="name" select="'image'"/>
                  <xsl:with-param name="id" select="$id"/>
                  <xsl:with-param name="value" select="$image"/>
                  <xsl:with-param name="width" select="210"/>
                  <xsl:with-param name="height" select="34"/>
                </xsl:call-template>

                <!--input type="submit" name="section_icon" value="Сохранить" class="submit"/>
                    </form-->
              </xsl:when>
            </xsl:choose>
          </td>
        </tr>
      </xsl:for-each>
    </table>
  </xsl:template>
</xsl:stylesheet>
