<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="options">
    <options>

      <xsl:if test="show_module">
        <xsl:choose>
          <xsl:when test="module">
        
          <form method="post">
            <sys_messages/>
            <xsl:for-each select="module/child::node()">
              <xsl:variable name="my_name">
                <xsl:value-of select="name()"/>
              </xsl:variable>
              <div class="newline">
                <xsl:value-of select="name()"/>
              </div>
              <xsl:for-each select="node">
                <div class="newline">
                  <input name="{$my_name}" type="radio" value="{text()}">
                    <xsl:if test="../../../active/key[text()=$my_name]/../value=text()">
                      <xsl:attribute name="checked"/>
                    </xsl:if>
                  </input>
                  <xsl:value-of select="./text()"/>
                </div>
              </xsl:for-each>
              <hr/>
            </xsl:for-each>
            <div>
              <input class="submit" name="save_module" type="submit" value="Сохранить"/>
            </div>
          </form>
          </xsl:when>
          <xsl:otherwise>
          Данный модуль не имеет настроек
          </xsl:otherwise>
      </xsl:choose>
      </xsl:if>
        <xsl:if test="show_section">
        <xsl:if test="active">
          <form method="post">
            <sys_messages/>
            <div class="newline">
              Назначить модуль
            <SELECT NAME="modul">
                <xsl:for-each select="modules">
                  <OPTION VALUE="{name}">
                    <xsl:if test="name=../active/module">
                      <xsl:attribute name="selected"/>
                    </xsl:if>
                    <xsl:value-of select="name"/>
                  </OPTION>
                </xsl:for-each>
              </SELECT>
            </div>
            <div class="newline">
              Назначить модуль для подразделов
              <SELECT NAME="submodul">
                <xsl:for-each select="modules">
                  <OPTION VALUE="{name}">
                    <xsl:if test="name=../active/sub_module">
                      <xsl:attribute name="selected"/>
                    </xsl:if>
                    <xsl:value-of select="name"/>
                  </OPTION>
                </xsl:for-each>
              </SELECT>
            </div>
            <div class="newline">
          Где отображать содержимое раздела
              <SELECT NAME="present">
                <OPTION VALUE="main">
                  <xsl:if test="active/present='main'"><xsl:attribute name="selected"></xsl:attribute></xsl:if>
                  На главной</OPTION>
                <OPTION VALUE="anywhere">
                  <xsl:if test="active/present='anywhere'"><xsl:attribute name="selected"></xsl:attribute></xsl:if>
                  Везде</OPTION>
                <OPTION VALUE="">
                  <xsl:if test="active/present=''"><xsl:attribute name="selected"></xsl:attribute></xsl:if>
                  По запросу
                </OPTION>
              </SELECT>
            </div>
            <div class="newline">
              <INPUT NAME="static" TYPE="checkbox">
                <xsl:if test="active/static='1'"><xsl:attribute name="checked"></xsl:attribute></xsl:if>
              </INPUT>
            Раздел нельзя удалять
          </div>
            <div class="newline">
              <INPUT NAME="images" TYPE="checkbox">
                <xsl:if test="active/show_img='1'"><xsl:attribute name="checked"></xsl:attribute></xsl:if>
              </INPUT>
              Разрешить  загрузку изображений
          </div>
            <div class="newline">
              <INPUT NAME="visible" TYPE="checkbox">
                <xsl:if test="active/show_visibility='1'"><xsl:attribute name="checked"></xsl:attribute></xsl:if>
              </INPUT>
                  Разрешить управление видимостью в главном меню
            </div>
            <div>
              <input class="submit" name="save_section" type="submit" value="Сохранить"/>
            </div>
          </form>
        </xsl:if>
      </xsl:if>

    </options>
  </xsl:template>
</xsl:stylesheet>
