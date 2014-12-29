from django import template

register = template.Library()

@register.simple_tag(takes_context=True)
def loginInformation(context):
	request = context['request']
	if 'user' in request.session:
		return '<li><a href="#">Welcome ' + request.session['user'] + '!</a></li><li id="logout-btn-li"><a id="logout-btn" href="/logout/"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>'
	else:
		return '<li id="login-btn-li"><a id="login-btn" href="#" data-reveal-id="loginModal"><i class="glyphicon glyphicon-log-in"></i> Log in</a></li>'
