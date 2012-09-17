<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="edit" mode="comments">
		<script type="text/javascript" src="/engine/js/jquery.uploadify.js" />
		<script type="text/javascript" src="/engine/js/swfobject.js" />
		<script type="text/javascript" src="/modules/comments/comments_admin.js" />
		<script language="javascript" type="text/javascript" src="/engine/tiny_mce/tiny_mce.js" />
		<script type="text/javascript" src="/engine/js/inittiny_admin.js" />
		<div class="module_content">
			<form method="post">
				<fieldset>

					<label>
						<span class="star">*</span>
						Дата:
					</label>
					<xsl:variable name="date_add">
						<xsl:call-template name="date_format">
							<xsl:with-param name="date" select="item/date_add" />
						</xsl:call-template>
					</xsl:variable>
					<input type="text" name="date_add" value="{$date_add}" id="datepicker" />

					<label>Фото:</label>
					<xsl:call-template name="upload_photo">
						<xsl:with-param name="xpath" select="'edit/item/'" />
						<xsl:with-param name="field" select="'photo_anons'" />
						<xsl:with-param name="module" select="'comments'" />
					</xsl:call-template>

					<label>
						<span class="star">*</span>
						Имя:
					</label>
					<input name="name" value="{item/name}" type="text" />

					<label>
						<span class="star">*</span>
						Отзыв:
					</label>
					<textarea name="text">
						<xsl:value-of select="item/text" />
					</textarea>
				</fieldset>

				<fieldset>
					<xsl:call-template name="saveButton">
						<xsl:with-param name="active" select="item/active" />
					</xsl:call-template>
				</fieldset>
			</form>
		</div>
	</xsl:template>

	<xsl:template match="list" mode="brief">
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
									<xsl:call-template name="substr">
										<xsl:with-param name="str" select="text" />
										<xsl:with-param name="num" select="300" />
										<xsl:with-param name="path" select="'otzyvy'" />
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
			<div class="all">
				<a href="/otzyvy/">Все отзывы</a>
			</div>
		</div>
	</xsl:template>

	<xsl:template match="list" mode="comments">
		<script type="text/javascript" src="/engine/js/jquery.form.js" />
		<script type="text/javascript" src="/modules/comments/comments.js" />
		<div class="article">
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
					Необходимо войти
					<script src="http://ulogin.ru/js/ulogin.js" />
					<div id="uLogin"
						x-ulogin-params="display=small&amp;fields=first_name,last_name,photo&amp;providers=vkontakte,odnoklassniki,mailru,facebook&amp;hidden=twitter,google,yandex,livejournal,openid&amp;redirect_uri=http%3A%2F%2Fazovskaya-riviera.com.ua" />
					чтобы оставить отзыв
				</div>
			</xsl:otherwise>
		</xsl:choose>

	</xsl:template>

	<xsl:template match="list_admin" mode="comments">
		<div class="control">
			<a href="{$get}?ADMIN&amp;ADD">
				<input type="submit" value="Добавить" />
			</a>
			<xsl:apply-templates select="pages" mode="digital" />
		</div>
		<xsl:if test="item">
			<div class="tab_container">
				<div class="tab_content" id="tab1" style="display: block;">
					<table cellspacing="0" class="tablesorter">
						<thead>
							<tr>
								<th>Дата</th>
								<th>Аватар</th>
								<th>Имя</th>
								<th style="width:70%;">Комментарий</th>
								<th style="width:15%;">Действия</th>
							</tr>
						</thead>
						<tbody>
							<xsl:for-each select="item">
								<tr>
									<td>
										<xsl:value-of select="date_add" />
									</td>
									<td>
										<xsl:choose>
											<xsl:when test="contains(photo_anons,'http')">
												<img src="{photo_anons}" />
											</xsl:when>
											<xsl:when test="photo_anons!=''">
												<img src="/75x75/comments/{photo_anons}" />
											</xsl:when>
										</xsl:choose>
									</td>
									<td>
										<xsl:value-of select="name" />
									</td>
									<td>
										<xsl:call-template name="substr">
											<xsl:with-param name="str" select="text" />
											<xsl:with-param name="num" select="100" />
										</xsl:call-template>

									</td>
									<td>
										<xsl:choose>
											<xsl:when test="active=1">
												<a href="{$get}?ADMIN&amp;ACTIVE={id}" class="publish_ajax">
													<input type="image" title="Деактивировать" src="/engine/modules/admin/images/icn_pause.png" />
												</a>
											</xsl:when>
											<xsl:otherwise>
												<a href="{$get}?ADMIN&amp;ACTIVE={id}" class="publish_ajax">
													<input type="image" title="Активировать" src="/engine/modules/admin/images/icn_play.png" />
												</a>
											</xsl:otherwise>
										</xsl:choose>

										<a href="{$get}?ADMIN&amp;EDIT={id}" class="edit">
											<input type="image" title="Редактировать" src="/engine/modules/admin/images/icn_edit.png" />
										</a>
										<a href="{$get}?ADMIN&amp;DEL={id}" class="delete_ajax" title="Удалить">
											<input type="image" title="Удалить" src="/engine/modules/admin/images/icn_trash.png" />
										</a>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</div>
			<div class="control">
				<xsl:apply-templates select="pages" mode="digital" />
			</div>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>