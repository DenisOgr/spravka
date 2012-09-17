<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="catalogue">
		<xsl:variable name="section">
			<xsl:value-of select="section" />
		</xsl:variable>

		<xsl:if test="not(detail)">
			<xsl:value-of select="anons/text" disable-output-escaping="yes" />
		</xsl:if>
		<xsl:if test="count!=''">
			<span class="tips" title="Статистика за год. Обнуляется в ночь с 31 декабря на 1 января">
				Количество просмотров:
				<xsl:value-of select="count" />
			</span>

			<!-- javascript coding -->
			<script>
				// execute your scripts when the DOM is ready. this is a good habit
				$(function() {



				// select all desired input fields and attach tooltips to them
				$(".tips").tooltip({

				// place tooltip on the right edge
				position: "center right",

				// a little tweaking of the position
				offset: [-2, 10],

				// use the built-in fadeIn/fadeOut effect
				effect: "fade",

				// custom opacity setting
				opacity: 0.7

				});
				});
			</script>
		</xsl:if>
		<xsl:choose>
			<xsl:when test="detail">
				<div>
					<br />
					<b>
						<xsl:value-of select="detail/name" />
					</b>
				</div>
				<div>
					<b>Адрес:</b>
					<br />
					<xsl:value-of select="detail/adres" />
				</div>
				<div>
					<b>Тел.:</b>
					<br />
					<xsl:value-of select="detail/tel" />
				</div>
				<div>
					<b>Тел.(моб):</b>
					<br />
					<xsl:value-of select="detail/tel_mob" />
				</div>
				<div>
					<b>Email:</b>
					<br />
					<a href="mailto:{detail/email}">
						<xsl:value-of select="detail/email" />
					</a>
				</div>
				<div>
					<b>URL:</b>
					<br />
					<a href="{detail/url}">
						<xsl:value-of select="detail/url" />
					</a>
				</div>
				<div>
					<div>
						<br />
						<xsl:value-of select="detail/text" disable-output-escaping="yes" />
					</div>
					<xsl:value-of select="detail/more" disable-output-escaping="yes" />
					&#160;
				</div>
         <xsl:apply-templates select="//comments"/>
			</xsl:when>
			<xsl:otherwise>

				<xsl:if test="item">


					<ul class="list_company">
						<xsl:for-each select="item">
							<li>
								<a href="?section={//section/node/current_id}&amp;item={id}">
									<xsl:value-of select="name" />
								</a>
							</li>
						</xsl:for-each>
					</ul>
				</xsl:if>

			</xsl:otherwise>
		</xsl:choose>

		<br />


		<div>
			<center>
				<xsl:value-of select="links" disable-output-escaping="yes" />
				&#160;
			</center>
			&#160;
		</div>
	</xsl:template>
</xsl:stylesheet>
