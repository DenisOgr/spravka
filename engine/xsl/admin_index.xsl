<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output encoding="utf-8" method="html" indent="yes" media-type="text/xhtml" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" cdata-section-elements="script"/>
  <xsl:include href="templates.xsl"/>
  <xsl:include href="../../modules/login/admin_login.xsl"/>
  <xsl:include href="admin_section.xsl"/>
  <!--xsl:include href="admin_catalogue.xsl"/-->

  <xsl:template match="root">
    <xsl:variable name="id"><xsl:value-of select="//section/node/current_id"/></xsl:variable>
    <html>
      <head>
        <base href="{domain}" />
        <title>Панель управления</title>
        <link rel="stylesheet" href="{$path}admin.css" type="text/css"/>

        <script type="text/javascript" src="/engine/js/utils.js"/>
        <script type="text/javascript" src="/admin/fckeditor/fckeditor.js"/>
        <script type="text/javascript" src="/engine/js/fckeditor.js"/>
        
        <script type="text/javascript" src="/engine/js/jquery.js" />
        <script type="text/javascript" src="/engine/js/jquery.cookie.js" />
        <link rel="stylesheet" type="text/css" href="/sm2/mp3-player-button.css" />
        <link rel="stylesheet" type="text/css" href="/sm2/flashblock.css" />
        <script type="text/javascript" src="/sm2/soundmanager2.js"></script>
        <script type="text/javascript" src="/sm2/mp3-player-button.js"></script>
      </head>

      <body>
      <xsl:choose>
      <xsl:when test="//content/count">
           <xsl:apply-templates select="content"/>
      </xsl:when>
      <xsl:otherwise>
        <table class="table" width="100%">
          <tr>
            <th colspan="2" class="upper">
              <img src="{$img}admin_09.gif" width="1" height="26"/>
              <div style="float:left;">Панель администрирования</div>
              <div style="float:right; margin-right:10px;">
                <a href="?logout">Выход</a>
              </div>
            </th>
          </tr>
          <tr>
            <td colspan="2" class="mites">
              <xsl:call-template name="mites">
                <xsl:with-param name="id" select="//section/node/current_id"/>
              </xsl:call-template>
            </td>
          </tr>
          <tr>
            <td id="section">
              <xsl:apply-templates select="section"/>
            </td>
            <td width="100%">
              <xsl:choose>
                <xsl:when test="content">
                  <table class="table" width="100%">
                    <tr>
                      <th>
                        <img src="{$img}admin_09.gif" width="1" height="26"/>
                        <div style="float: left; "><a href="/admin/?section={$id}">
                          <xsl:value-of select="//section/node/current_name"/>
                          </a>
                        </div>
                        <img src="{$img}admin_09.gif" width="1" height="26"/>
                        <div  style="float: left; ">
                          <a href="/admin/?section={$id}&amp;meta">МЕТА тэги</a>
                        </div>
                        <xsl:if test="//user/text()='superadmin'">
                        
                       <img src="{$img}admin_09.gif" width="1" height="26"/>
                        <div  style="float: left; ">
                          <a href="/admin/?section={$id}&amp;options=section">Настройка раздела</a>
                        </div>
                        <img src="{$img}admin_09.gif" width="1" height="26"/>
                        <div  style="float: left; ">
                          <a href="/admin/?section={$id}&amp;options=module">Настройка модуля</a>
                          </div>
                        </xsl:if>
                      </th>
                    </tr>
                    <tr>
                      <td>
                        <xsl:apply-templates select="content"/>
                      </td>
                    </tr>
                  </table>
                </xsl:when>
                <xsl:otherwise> Кликните на название раздела для работы с ним.<br/> С помощью иконок, расположенных слева, можно выполнять операции с разделами. </xsl:otherwise>
              </xsl:choose>
            </td>
          </tr>
          <tr>
            <td colspan="2" id="copyright">(c) 2007</td>
          </tr>
        </table>
        </xsl:otherwise>
        </xsl:choose>
      </body>
    </html>
  </xsl:template>
  
  <xsl:template name="mites">
    <xsl:param name="id"/>
    <xsl:param name="path"/>
    <xsl:choose>
      <xsl:when test="//section/node/node/add/id_parent[../../node[1]=$id] != ''">
        <xsl:call-template name="mites">
          <xsl:with-param name="id" select="//section/node/node/add/id_parent[../../node[1]=$id]"/>
          <xsl:with-param name="path">
            >> &lt;a href="/admin/?section=<xsl:value-of select="$id"/>"><xsl:value-of select="//section/node/node/add/name[../../node[1]=$id]"/>&lt;/a> <xsl:value-of select="$path"/>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:if test="$id!='' "><a href="/admin/">Первый уровень</a> >> </xsl:if>
       <a href="/admin/?section={$id}"><xsl:value-of select="//section/node/node/add/name[../../node[1]=$id]"/></a><xsl:value-of select="$path" disable-output-escaping="yes"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
</xsl:stylesheet>
