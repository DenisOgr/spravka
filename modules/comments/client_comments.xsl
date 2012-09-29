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
		<div id="comment">
			<xsl:choose>
				<xsl:when test="user">
					<h2> Оставить отзыв </h2>
					<b>
						<xsl:value-of select="concat(user/first_name,' ', user/last_name)" />
					</b>
					<a href="/admin?logout" style="float:right;">Выйти</a>
					<form method="post">
						<input type="hidden" name="id_user" value="{user/id}" />
						<input name="id_item" type="hidden" value="{//requests/get/ITEM}" />
						<img src="{user/photo}" class="photo"/>
						<textarea id="comment_text" name="text"></textarea>
						<br />
						<input type="submit" name="save_message" value="Отправить" />
					</form>
				</xsl:when>
				<xsl:otherwise>
					<div id="terms">
						<div id="t_message">Чтобы оставить отзыв, необходимо войти</div>
						<script src="http://ulogin.ru/js/ulogin.js"></script>

						<div id="uLogin"
							x-ulogin-params="display=small;fields=first_name,last_name,photo;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter,livejournal,yandex;hidden=;redirect_uri=http%3A%2F%2Fspravka-melitopol.info/ulogin_xd.html;callback=social_login"></div>
					</div>
				</xsl:otherwise>
			</xsl:choose>
		</div>
	</xsl:template>
</xsl:stylesheet>
