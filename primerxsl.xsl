<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <h2>Графические редакторы</h2>
        <table border="1">
            <tr bgcolor="#9acd32">
                <th style="text-align:left">Название</th>
                <th style="text-align:left">Описание</th>
                <th style="text-align:left">Лицензия</th>
                <th style="text-align:left">Поддерживаемые ОС</th>
                <th style="text-align:left">Иконка</th>
            </tr>
            <xsl:apply-templates select="catalog/cd">
                <xsl:sort select="name"/>
            </xsl:apply-templates>
        </table>
    </xsl:template>

    <xsl:template match="cd">
        <tr>
            <td>
                <xsl:value-of select="name"/>
            </td>
            <td>
                <xsl:value-of select="description"/>
            </td>
            <td>
                <xsl:if test="license='Бесплатная'">
                    <span style="color:green">
                        <xsl:value-of select="license"/>
                    </span>
                </xsl:if>
                <xsl:if test="license='Платная'">
                    <span style="color:red">
                        <xsl:value-of select="license"/>
                    </span>
                </xsl:if>
            </td>
            <td>
                <xsl:value-of select="os"/>
            </td>
            <td>
                <img src="{icon}" alt="{name}"/>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>