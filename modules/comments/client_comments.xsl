<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="comments">
		<script type="text/javascript" src="/modules/comments/comments.js" />
		<div class="feedback">
			<div class="users">
				<ul>
					<xsl:for-each select="item">
						<li>
							<div class="user">
								<div class="date">
									<xsl:value-of select="date_add" />
								</div>
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
									<xsl:value-of select="text" />
								</p>

							</div>
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</div>

		<xsl:choose>
			<xsl:when test="//sub_login/user/id">
				<h2> Оставить отзыв </h2>
				<div class="add-post" style="clear:both;">
					<div id="comments_message" />
					&#160;
					<form method="post" id="addComment">
						<div class="name">
							<xsl:value-of select="concat(//sub_login/user/first_name,' ',//sub_login/user/last_name)" />
						</div>
						<div>
							<xsl:if test="//sub_login/user/avatar!=''">
								<img src="{//sub_login/user/avatar}" style="float:left;margin:0px 5px;" />
							</xsl:if>
							<textarea name="text"></textarea>
						</div>
						<div class="right">
							<input name="id_item" type="hidden" value="{//requests/get/ITEM}" />
							<input type="submit" class="button" value="Отправить" />
						</div>
					</form>
				</div>
			</xsl:when>
			<xsl:otherwise>
				<div id="terms">
					<div id="t_message">Чтобы оставить отзыв, необходимо войти</div>
					<script src="http://ulogin.ru/js/ulogin.js"></script>
					<div id="uLogin"
						x-ulogin-params="display=small;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter,livejournal,yandex;hidden=;redirect_uri=http%3A%2F%2Fspravka-melitopol.info"></div>
				</div>
			</xsl:otherwise>
		</xsl:choose>

	</xsl:template>
</xsl:stylesheet>
