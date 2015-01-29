from django import template

register = template.Library()

@register.simple_tag(takes_context = True)
def getLoggedUser(context):
	request = context['request']
	if 'user' in request.session:
		return request.session['user']
	else:
		return ''
