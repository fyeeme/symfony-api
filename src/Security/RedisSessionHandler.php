<?php

namespace App\Security;
use Codeages\Biz\Framework\Context\Biz;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;


/**
 * Redis based session storage handler based on the Redis class
 * provided by the PHP Redis extension.
 *
 * @see http://php.net/memcached
 *
 * @author Drak <drak@zikula.org>
 */

class RedisSessionHandler extends AbstractSessionHandler
{
    private $biz;

    /**
     * @var int Time to live in seconds
     */
    private $ttl;

    /**
     * @var string Key prefix for shared environments
     */
    private $prefix;

    /**
     * Constructor.
     *
     * List of available options:
     *  * prefix: The prefix to use for the memcached keys in order to avoid collision
     *  * expiretime: The time to live in seconds.
     *
     * RedisSessionHandler constructor.
     * @param Biz $biz
     * @param array $options
     */
    public function __construct(Biz $biz, array $options = array())
    {
        $this->biz = $biz;

        if ($diff = array_diff(array_keys($options), array('prefix', 'expiretime'))) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doRead($sessionId)
    {
        return $this->getRedis()->get($this->prefix.$sessionId) ?: '';
    }

    /**
     * {@inheritdoc}
     */
    public function updateTimestamp($sessionId, $data)
    {
        $this->getRedis()->expire($this->prefix.$sessionId,  $this->ttl);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($sessionId, $data)
    {
        return $this->getRedis()->setex($this->prefix.$sessionId, $this->ttl, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDestroy($sessionId)
    {
        return $this->getRedis()->del($this->prefix.$sessionId);
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        // not required here because redis will auto expire the records anyhow.
        return true;
    }

    /**
     * Return a Redis instance.
     *
     * @return \Redis
     */
    protected function getRedis()
    {
        return $this->biz['redis'];
    }
}

