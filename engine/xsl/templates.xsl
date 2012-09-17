<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output cdata-section-elements="script"/>
  <xsl:variable name="path">/</xsl:variable>
  <xsl:variable name="img"><xsl:value-of select="$path"/>img/</xsl:variable>


  <xsl:template match="content">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="@* | *" name="all">
    <xsl:copy>
      <xsl:apply-templates select="@* | node()"/>
    </xsl:copy>
  </xsl:template>

  <xsl:template name="sys_messages" match="sys_messages">
    <xsl:for-each select="//messages/content/error/node">
      <div class="red">
        <xsl:value-of select="//messages/content/error/node"/>
      </div>
    </xsl:for-each>
    <xsl:for-each select="//messages/content/success/node">
      <div class="success">
        <xsl:value-of select="//messages/content/success/node"/>
      </div>
    </xsl:for-each>
  </xsl:template>

  <xsl:template match="upload">
    <div align="center">
      <script>
                function delete_<xsl:value-of select="@name"/>(){
                var f_frame=frames['<xsl:value-of select="@name"/>_frame'];
                var href_frame=frames['<xsl:value-of select="@name"/>_frame'].location.href;
                f_frame.location=href_frame+'&amp;delete';
                $$('<xsl:value-of select="@name"/>').value=0;
                $$('<xsl:value-of select="@name"/>_foto').innerHTML="Удаление фото ...";
                }
                //</script>
      <div id="{@name}_foto">Загрузка ...</div>
      <input type="hidden" value="{@value}" id="{@name}" name="{@name}"/>
      <iframe name="{@name}_frame" src="/load_img.php?name={@name}&amp;value={@value}&amp;prefix={@name}&amp;width={@width}&amp;thumb={@thumb}&amp;height={@height}" width="400" height="75" frameborder="0"> </iframe>
    </div>
  </xsl:template>

  <xsl:template name="upload">
    <xsl:param name="name"/>
    <xsl:param name="id"/>
    <xsl:param name="value"/>
    <xsl:param name="prefix" select="concat($name,'_',$id)"/>
    <xsl:param name="thumb">yes</xsl:param>
    <xsl:param name="width" select="*"/>
    <xsl:param name="height" select="*"/>  
    
    <div align="center">
      <script>
        function delete_<xsl:value-of select="$name"/>(){
        var f_frame=frames['<xsl:value-of select="$name"/>_frame'];
        var href_frame=frames['<xsl:value-of select="$name"/>_frame'].location.href;
        f_frame.location=href_frame+'&amp;delete';
        $$('<xsl:value-of select="$name"/>').value=0;
        $$('<xsl:value-of select="$name"/>_foto').innerHTML="Удаление фото ...";
        }
        //</script>
      <div id="{$name}_foto">Загрузка ...</div>
      <input type="hidden" value="{$value}" id="{$name}" name="{$name}"/>
      <iframe name="{$name}_frame" src="/load_img.php?name={$name}&amp;value={$value}&amp;prefix={$prefix}&amp;width={$width}&amp;thumb={$thumb}&amp;height={$height}" width="300" height="60" frameborder="0"> </iframe>
    </div>
  </xsl:template>

</xsl:stylesheet>
