<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">



	<xsl:template name="bottom_menu">
		<table cellpadding="5" cellspacing="0" border="0" align="right">
			<tr>
				<xsl:for-each select="//section/node/node[node[2][text()=1] and add/visible=1]">
					<xsl:variable name="id" select="node[position()=1]" />
					<xsl:variable name="level" select="node[position()=2]" />
					<xsl:variable name="name" select="add/name" />
					<xsl:variable name="visible" select="add/visible" />
					<td>
						<a class="menu_bottom_link" href="?section={$id}" title="{$name}">
							<xsl:value-of select="$name" />
						</a>
					</td>
					<xsl:if test="position()!=last()">
						<td class="menu_bottom_separator">|</td>
					</xsl:if>
				</xsl:for-each>
			</tr>
		</table>
	</xsl:template>

	<xsl:template name="main_menu">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/2m.gif" onMouseOut="hidemenu()" onMouseOver="cancelhide()">
			<tr>
				<td width="31" height="29">
					<img src="images/1m.gif" width="31" height="29" />
				</td>
				<xsl:for-each select="//section/node/node[node[2][text()=1] and add/visible=1]">
					<xsl:variable name="id" select="node[position()=1]" />
					<xsl:variable name="level" select="node[position()=2]" />
					<xsl:variable name="name" select="add/name" />
					<xsl:variable name="alias" select="add/alias" />
					<xsl:variable name="visible" select="add/visible" />
					<xsl:if test="position()!=1">
						<td width="14" height="29">
							<img src="images/3m.gif" width="14" height="29" />
						</td>
					</xsl:if>
					<td>
						<div>
							<xsl:choose>
								<xsl:when test="following-sibling::node[1]/node[2][text()=2]">
									<xsl:attribute name="onMouseOver">show(this,'submenu<xsl:value-of select="$id" />','0')</xsl:attribute>
								</xsl:when>
								<xsl:otherwise>
									<xsl:attribute name="onMouseOver">show(this,'submenu0','0')</xsl:attribute>
								</xsl:otherwise>
							</xsl:choose>
							<a title="{$name}" class="white_link">
								<xsl:choose>
									<xsl:when test="$alias!=''">
										<xsl:attribute name="href"><xsl:value-of select="concat('/',$alias)" /></xsl:attribute>
									</xsl:when>
									<xsl:otherwise>
										<xsl:attribute name="href"><xsl:value-of select="concat('?section=',$id)" /></xsl:attribute>
									</xsl:otherwise>
								</xsl:choose>
								<xsl:value-of select="$name" />
							</a>
						</div>
					</td>
				</xsl:for-each>
				<td width="26" height="29">
					<img src="images/4m.gif" width="26" height="29" />
				</td>
			</tr>
		</table>


		<DIV ID="submenu0" STYLE="LEFT: -1000px;OVERFLOW: hidden;POSITION: absolute;TOP: -1000px; " onMouseOut="hidemenu()" onMouseOver="cancelhide()">
			<img src="images/spacer.gif" width="0" height="0" alt="" />
		</DIV>

		<xsl:for-each select="section/node/node[node[2][text()=1] and add/visible=1]">
			<xsl:variable name="id" select="node[position()=1]" />
			<xsl:variable name="level" select="node[position()=2]" />
			<xsl:variable name="name" select="add/name" />
			<xsl:variable name="visible" select="add/visible" />
			<xsl:variable name="pos" select="add/priority" />
			<DIV ID="submenu{$id}" STYLE="LEFT: -1000px;OVERFLOW: hidden;POSITION: absolute;TOP: -1000px; z-index:1000; padding:10px; background-color:#ff9700;"
				onMouseOut="hidemenu()" onMouseOver="cancelhide()">
				<table width="200" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<xsl:for-each select="../node">
								<xsl:variable name="id_parent" select="add/id_parent" />
								<xsl:if test="node[2][text()=2] and add/id_parent[text()=$id]">
									<div align="left">
										<xsl:choose>
											<xsl:when test="//section/node/node/add/id_parent=node[1]">
												<xsl:attribute name="onMouseOver">show(this,'submenu<xsl:value-of select="node[1]" />','1')</xsl:attribute>
											</xsl:when>
											<xsl:otherwise>
												<xsl:attribute name="onMouseOver">show(this,'submenu0','1')</xsl:attribute>
											</xsl:otherwise>
										</xsl:choose>
										<a class="white_link">


											<xsl:attribute name="href">?section=<xsl:value-of select="node[1]" /></xsl:attribute>
											<xsl:value-of select="add/name" />
										</a>
									</div>
									<div style="height: 1; background: #094f96">
										<img src="images/spacer.gif " alt="" height="1" width="100%" />
									</div>
								</xsl:if>
							</xsl:for-each>
						</td>
					</tr>
				</table>
			</DIV>
		</xsl:for-each>


		<xsl:for-each select="section/node/node[node[2][text()=2] and add/visible=1]">
			<xsl:variable name="id" select="node[position()=1]" />
			<xsl:variable name="level" select="node[position()=2]" />
			<xsl:variable name="name" select="add/name" />
			<xsl:variable name="visible" select="add/visible" />
			<xsl:variable name="pos" select="add/priority" />
			<DIV ID="submenu{$id}" STYLE="LEFT: -1000px;OVERFLOW: hidden;POSITION: absolute;TOP: -1000px; z-index:1000;  padding:10px; background-color:#ff9700;"
				onMouseOut="hidemenu()" onMouseOver="cancelhide()">
				<table width="200" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<xsl:for-each select="../node">
								<xsl:variable name="id_parent" select="add/id_parent" />
								<xsl:if test="node[2][text()=3] and add/id_parent[text()=$id]">
									<a class="white_link">
										<xsl:attribute name="href">?section=<xsl:value-of select="node[1]" /></xsl:attribute>
										<xsl:value-of select="add/name" />
									</a>

									<div style="height: 1; background: #094f96">
										<img src="images/spacer.gif " alt="" height="1" width="100%" />
									</div>
								</xsl:if>
							</xsl:for-each>
						</td>
					</tr>
				</table>
			</DIV>
		</xsl:for-each>
	</xsl:template>


	<xsl:template name="second_menu">
		<xsl:for-each select="//section/node/node[add/id_parent=//section/node/current_id and add/visible=1]">
			<a href="?section={node[1]}">
				<xsl:value-of select="add/name" />
			</a>
			<br />
		</xsl:for-each>
		<xsl:if test="not(//content/list_articles/articles/item)"><!-- <br/>Количество просмотров: <xsl:value-of select="//content/list_articles/count"/> -->
		</xsl:if>
	</xsl:template>


	<xsl:template name="submenu">
		<xsl:choose>
			<xsl:when test="//section/node/parent_id!='' or  //section/node/current_id=//section/node/node/add/id_parent">
				<xsl:variable name="current">
					<xsl:choose>
						<xsl:when test="//section/node/parent_id!=''">
							<xsl:value-of select="//section/node/parent_id" />
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="//section/node/current_id" />
						</xsl:otherwise>
					</xsl:choose>
				</xsl:variable>

				<xsl:for-each select="//section/node/node[add/id_parent=$current]">
					<xsl:variable name="id" select="node[position()=1]" />
					<img src="images/str2.gif" hspace="3" align="absmiddle" />
					<a href="?section={$id}" title="{add/name}" class="plink">
						<xsl:value-of select="add/name" />
					</a>
				</xsl:for-each>
			</xsl:when>
			<xsl:otherwise>
				&#160;
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
