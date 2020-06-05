import os
import socket

from ssh2.session import Session
from ssh2.session import LIBSSH2_HOSTKEY_HASH_SHA1, LIBSSH2_HOSTKEY_TYPE_RSA
from ssh2.knownhost import LIBSSH2_KNOWNHOST_TYPE_PLAIN, \
    LIBSSH2_KNOWNHOST_KEYENC_RAW, LIBSSH2_KNOWNHOST_KEY_SSHRSA

class Ssh:
    host = ''
    user = ''
    port = ''
    sock = None
    session = None
    command_output = ''

    def __init__(self, host, user, port):
        self.host = host
        self.port = port

        self.connect()
        self.create_session()

    def connect(self):
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.connect((self.host, self.port))

    def create_session(self):
        self.session = Session()
        self.session.handshake(self.sock)
        self.session.userauth_publickey(self.user, 'keydatahere')

    def exec(self, command):
        chan = self.session.open_session()
        chan.execute(command)
        size, data = chan.read()
        while size > 0:
            self.command_output = self.command_output + data
            size, data = chan.read()
        chan.clsose()