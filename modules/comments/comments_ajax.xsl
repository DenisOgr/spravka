<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />
	<xsl:include href="./../xsl/templates.xsl" />
	<xsl:template match="mod_comments">
		<xsl:apply-templates mode="comments" />
	</xsl:template>

	<xsl:template match="*" mode="comments" />

	<xsl:template name="messages" match="messages">
		<xsl:if test="count(//messages/content/error)>0">
			<div class="mcontainer">
				<ul class="message error">
					<li style="padding-bottom: 10px !important;">
						<strong>ОШИБКА!</strong>
					</li>
					<xsl:for-each select="//messages/content/error/item">
						<li>
							<xsl:value-of select="." disable-output-escaping="yes" />
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>

		<xsl:if test="count(//messages/content/success)>0">
			<div class="mcontainer">
				<ul class="message success">
					<xsl:for-each select="//messages/content/success/item">
						<li>
							<xsl:value-of select="." disable-output-escaping="yes" />
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>

		<xsl:if test="count(//messages/content/notice)>0">
			<div class="mcontainer">
				<ul class="message notice">
					<xsl:for-each select="//messages/content/notice/item">
						<li>
							<xsl:value-of select="." disable-output-escaping="yes" />
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>
	</xsl:template>

	<xsl:template match="messages" mode="comments">
		<xsl:apply-templates select="." />
	</xsl:template>

	<xsl:template name="rus_months">
		<xsl:param name="date" />
		<xsl:choose>
			<xsl:when test="substring($date, 9,1)='0'">
				<xsl:value-of select="concat(substring($date, 10,2), ' ')" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="concat(substring($date, 9,2), ' ')" />
			</xsl:otherwise>
		</xsl:choose>
		<xsl:call-template name="month">
			<xsl:with-param name="date" select="$date" />
		</xsl:call-template>
		<xsl:if test="substring($date, 0,5)!='0000'">
			<xsl:value-of select="concat(' ', substring($date, 0,5))" />
		</xsl:if>
	</xsl:template>

	<xsl:template match="list" mode="comments">
		<div class="feedback">
			<div class="users">
				<ul>
					<xsl:for-each select="item">
						<li>
							<div class="user">
								<xsl:choose>
									<xsl:when test="contains(photo_anons,'http')">
										<img src="{photo_anons}" />
									</xsl:when>
									<xsl:when test="photo_anons!=''">
										<img src="/75x75/comments/{photo_anons}" />
									</xsl:when>
								</xsl:choose>
								<div class="name">
									<xsl:value-of select="name" />
								</div>
								<p>
									<xsl:call-template name="nl2br">
										<xsl:with-param name="string" select="text" />
									</xsl:call-template>
								</p>
								<div class="date">
									<xsl:value-of select="date_add" />
								</div>
							</div>
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</div>
		<xsl:apply-templates select="pages" mode="digital" />
	</xsl:template>

</xsl:stylesheet>