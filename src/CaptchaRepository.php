<?php

namespace Superman2014\CaptchaRepository;

class CaptchaRepository
{
    const CAPTCHA_EXPIRE = -1;
    const CAPTCHA_ERROR = 0;

    protected $connection;
	protected $config;

    public function __construct($app)
    {
		$this->config = $app['config']->get('captcha');
        $this->connection = $app['redis']->connection($this->config['redis_connection']);
    }

    protected function getCaptchaKey($name)
    {
        return implode(':', [$this->config['captcha_key'], $name]);
    }

    /**
     * 获取存档验证码.
     *
     * @param string $name 用户的手机号
     *
     * @return string
     */
    public function getCaptcha($name)
    {
        return $this->connection->get($this->getCaptchaKey($name));
    }

    /**
     * 临时存档验证码.
     *
     * @param string  $name         用户的手机号
     * @param string  $inputCaptcha 用户输入的验证码
     * @param integer $expire       有效期
     *
     * @return bool
     */
    public function achiveCaptcha($name, $inputCaptcha, $expire = null)
    {
		$expire = $expire ?:$this->config['captcha_expire'];
        return $this->connection->setEx($this->getCaptchaKey($name), $expire, $inputCaptcha);
    }

    /**
     * 比较验证码.
     *
     * @param string $name         用户的手机号
     * @param string $inputCaptcha 用户输入的验证码
     *
     * @return -1 失效 0 失败 1 正确
     */
    public function compareCaptcha($name, $inputCaptcha)
    {
        return ($captcha = $this->getCaptcha($name))
            ? ($captcha == $inputCaptcha?1:0)
            :-1;
    }

    /**
     * 发送验证码是否频繁.
     *
     * @param $name
     * @return bool
     */
    public function isOverLimit($name)
    {
        $key = implode(':', [$this->config['captcha_limit_key'], $name]);
        $number = $this->connection->get($key);

        if ($number) {
            if ($number > $this->config['captcha_limit_times'] - 1) {
                return true;
            }

			$this->connection->incr($key);
        } else {
			$this->connection->setEx(
				$key,
				$this->config['captcha_expire'],
				1
			);
        }

		return false;
    }
}

