#!/usr/bin/env python

import sys
import PAM
import sys

password = ''

def pam_conv(auth, query_list, userData):
    return [(password, 0)]

service = 'passwd'

if len(sys.argv) == 3:
	user = sys.argv[1]
	password = sys.argv[2]
else:
	user = None
	password = None

auth = PAM.pam()
auth.start(service)
if user != None:
	auth.set_item(PAM.PAM_USER, user)
auth.set_item(PAM.PAM_CONV, pam_conv)
try:
	auth.authenticate()
	auth.acct_mgmt()
except PAM.error, resp:
	sys.stdout.write('FAIL')
except:
	sys.stdout.write('FAIL')
else:
	sys.stdout.write('OK')
